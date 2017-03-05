<?php

namespace Contact\Model;


use Contact\Entity\AddressInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Hydrator\HydratorInterface;

class AddressModel implements AddressModelInterface
{
    const TABLE_NAME = 'contact_address';

    /**
     * @var AdapterInterface
     */
    private $db;

    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * @var AddressInterface
     */
    private $addressPrototype;

    /**
     * AddressModel constructor.
     * @param AdapterInterface $db
     * @param HydratorInterface $hydrator
     * @param AddressInterface $addressPrototype
     */
    public function __construct(
        AdapterInterface $db,
        HydratorInterface $hydrator,
        AddressInterface $addressPrototype
    )
    {
        $this->db = $db;
        $this->hydrator = $hydrator;
        $this->addressPrototype = $addressPrototype;
    }

    /**
     * @inheritDoc
     */
    public function fetchAllAddresses($contactId)
    {
        $sql = new Sql($this->db);
        $select = $sql->select(self::TABLE_NAME);
        $select->where(['contact_id = ?' => $contactId]);

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            throw new \DomainException('Cannot find an address for given contact');
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->addressPrototype);
        $resultSet->initialize($result);

        if (!$resultSet) {
            throw new \RuntimeException('Cannot process the data for this contact');
        }

        return $resultSet;
    }

    /**
     * @inheritDoc
     */
    public function findAddressById($contactId, $contactAddressId)
    {
        // TODO: Implement findAddressById() method.
    }

    /**
     * @inheritDoc
     */
    public function saveAddress(AddressInterface $address)
    {
        // TODO: Implement saveAddress() method.
    }

    /**
     * @inheritDoc
     */
    public function deleteAddress(AddressInterface $address)
    {
        // TODO: Implement deleteAddress() method.
    }

}