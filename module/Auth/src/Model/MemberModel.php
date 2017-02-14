<?php

namespace Auth\Model;


use Auth\Entity\MemberEntity;
use Auth\Entity\MemberInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Hydrator\HydratorInterface;

class MemberModel
{
    /**
     * @var AdapterInterface
     */
    protected $db;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @var MemberInterface
     */
    protected $memberPrototype;

    /**
     * MemberModel constructor.
     * @param AdapterInterface $db
     * @param HydratorInterface $hydrator
     * @param MemberInterface $memberPrototype
     */
    public function __construct(
        AdapterInterface $db,
        HydratorInterface $hydrator,
        MemberInterface $memberPrototype
    )
    {
        $this->db = $db;
        $this->hydrator = $hydrator;
        $this->memberPrototype = $memberPrototype;
    }


    public function getMember($id)
    {
        $sql       = new Sql($this->db);
        $select    = $sql->select('member');
        $select->where(['member_id = ?' => $id]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();

        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            throw new \RuntimeException(sprintf(
                'Failed retrieving contact with identifier "%s"; unknown database error.',
                $id
            ));
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->memberPrototype);
        $resultSet->initialize($result);
        $member = $resultSet->current();

        if (! $member) {
            throw new \InvalidArgumentException(sprintf(
                'Contact with identifier "%s" not found.',
                $id
            ));
        }

        return $member;
    }

    public function saveMember(MemberInterface $member)
    {
        $date = new \DateTime();
        $insert = new Insert('member');
        $data = $this->hydrator->extract($member);
        if (0 === (int) $member->getMemberId()) {
            unset ($data['member_id']);
        }
        $insert->values($data);
        $sql = new Sql($this->db);
        $stmt = $sql->prepareStatementForSqlObject($insert);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException('Database error occurred during storage of new member');
        }
        if (0 === (int) $member->getMemberId()) {
            $memberId = $result->getGeneratedValue();
            return new MemberEntity($memberId, $member->getLinkedinId(), $member->getAccessToken());
        }
        return $member;
    }
}