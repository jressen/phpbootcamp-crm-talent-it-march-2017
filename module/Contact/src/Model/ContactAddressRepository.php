<?php

namespace Contact\Model;


use Contact\Entity\ContactAddressInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Hydrator\HydratorInterface;

class ContactAddressRepository implements ContactAddressRepositoryInterface
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
     * @var ContactAddressInterface
     */
    protected $contactAddressPrototype;

    /**
     * ContactAddressRepository constructor.
     * @param AdapterInterface $db
     * @param HydratorInterface $hydrator
     * @param ContactAddressInterface $contactAddressPrototype
     */
    public function __construct(AdapterInterface $db, HydratorInterface $hydrator, ContactAddressInterface $contactAddressPrototype)
    {
        $this->db = $db;
        $this->hydrator = $hydrator;
        $this->contactAddressPrototype = $contactAddressPrototype;
    }

    /**
     * @inheritDoc
     */
    public function getAddressById($contactAddressId, $contactId)
    {
        $select = new Select('contact_address');
        $select->where([
            'contact_address_id = ?' => $contactAddressId,
            'contact_id = ?' => $contactId,
        ]);
        $sql = new Sql($this->db);
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            throw new \RuntimeException(
                'Something went wrong retrieving address details'
            );
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->contactAddressPrototype);
        $resultSet->initialize($result);

        $contactAddress = $resultSet->current();
        if (!$contactAddress) {
            throw new \InvalidArgumentException('Cannot find a contact address');
        }

        return $contactAddress;

    }

    /**
     * @inheritDoc
     */
    public function getAllAddresses($contactId)
    {
        $select = new Select('contact_address');
        $select->where([
            'contact_id = ?' => $contactId,
        ]);
        $sql = new Sql($this->db);
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            throw new \RuntimeException(
                'Something went wrong retrieving address details'
            );
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->contactAddressPrototype);
        $resultSet->initialize($result);

        $contactAddresses = $resultSet;
        if (!$contactAddresses) {
            throw new \InvalidArgumentException('Cannot find a contact address');
        }

        return $contactAddresses;
    }

}