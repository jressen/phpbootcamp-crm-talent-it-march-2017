<?php

namespace Contact\Model;

use Contact\Entity\ContactEntityInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Hydrator\HydratorInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class ContactRepository implements ContactRepositoryInterface
{
    /**
     * @var AdapterInterface
     */
    private $db;

    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * @var ContactEntityInterface
     */
    private $contactPrototype;

    /**
     * ZendDbSqlRepository constructor.
     *
     * @param AdapterInterface $db
     * @param HydratorInterface $hydrator
     * @param ContactEntityInterface $contactEntity
     */
    public function __construct(
        AdapterInterface $db,
        HydratorInterface $hydrator,
        ContactEntityInterface $contactEntity
    )
    {
        $this->db = $db;
        $this->hydrator = $hydrator;
        $this->contactPrototype = $contactEntity;
    }


    /**
     * @inheritDoc
     */
    public function findAllContacts($memberId)
    {
        $sql       = new Sql($this->db);
        $select    = $sql->select('contact');

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
        $sql       = new Sql($this->db);
        $select    = $sql->select('contact');
        $select->where(['member_id = ?' => $memberId]);
        $select->where(['contact_id = ?' => $contactId]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();

        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            throw new \RuntimeException(sprintf(
                'Failed retrieving contact with identifier "%s"; unknown database error.',
                $contactId
            ));
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->contactPrototype);
        $resultSet->initialize($result);
        $contact = $resultSet->current();

        if (! $contact) {
            throw new \InvalidArgumentException(sprintf(
                'Contact with identifier "%s" not found.',
                $contactId
            ));
        }

        return $contact;
    }
}