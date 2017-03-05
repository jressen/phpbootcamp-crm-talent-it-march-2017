<?php

namespace Contact\Model;


use Contact\Entity\ContactInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Hydrator\HydratorInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class ContactModel implements ContactModelInterface
{
    const TABLE_NAME = 'contact';

    /**
     * @var AdapterInterface
     */
    protected $db;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @var ContactInterface
     */
    protected $contactPrototype;

    /**
     * ContactModel constructor.
     *
     * @param AdapterInterface $db
     * @param HydratorInterface $hydrator
     * @param ContactInterface $contactPrototype
     */
    public function __construct(AdapterInterface $db, HydratorInterface $hydrator, ContactInterface $contactPrototype)
    {
        $this->db = $db;
        $this->hydrator = $hydrator;
        $this->contactPrototype = $contactPrototype;
    }

    /**
     * @inheritdoc
     */
    public function fetchAllContacts($memberId)
    {
        $sql = new Sql($this->db);
        $select = $sql->select(self::TABLE_NAME);
        $select->where(['member_id = ?' => $memberId]);
        $select->order(['last_name']);

        $resultSet = new HydratingResultSet($this->hydrator, $this->contactPrototype);

        $adapter = new DbSelect($select, $this->db, $resultSet);
        $paginator = new Paginator($adapter);

        return $paginator;
    }

    /**
     * @inheritDoc
     */
    public function findContact($memberId, $contactId)
    {
        $sql = new Sql($this->db);
        $select = $sql->select(self::TABLE_NAME);
        $select->where([
            'member_id = ?' => $memberId,
            'contact_id = ?' => $contactId,
        ]);

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            throw new \DomainException('Cannot find contac');
        }

        return $this->hydrator->hydrate($result->current(), $this->contactPrototype);
    }

    /**
     * @inheritDoc
     */
    public function saveContact($memberId, ContactInterface $contact)
    {
        // TODO: Implement saveContact() method.
    }

    /**
     * @inheritDoc
     */
    public function deleteContact($memberId, ContactInterface $contact)
    {
        // TODO: Implement deleteContact() method.
    }

}