<?php

namespace Auth\Model;


use Auth\Entity\MemberInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
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
}