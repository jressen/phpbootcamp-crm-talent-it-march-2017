<?php

namespace Contact\Model;


use Contact\Entity\AddressInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
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
        if (0 < (int) $address->getContactAddressId()) {
            return $this->updateAddress($address);
        }
        return $this->insertAddress($address);
    }

    /**
     * @inheritDoc
     */
    public function deleteAddress(AddressInterface $address)
    {
        // TODO: Implement deleteAddress() method.
    }

    private function insertAddress(AddressInterface $address)
    {
        $date = date('Y-m-d H:i:s');
        $addressData = $this->hydrator->extract($address);
        unset(
            $addressData['contact_address_id']
        );
        $addressData['created'] = $addressData['modified'] = date('Y-m-d H:i:s');
        $addressData['country_code'] = $address->getCountry()->getIso();

        $insert = new Insert(self::TABLE_NAME);
        $insert->values($addressData);

        $sql = new Sql($this->db);
        $stmt = $sql->prepareStatementForSqlObject($insert);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException('Something was wrong with stroring the address');
        }
        $address->setContactAddressId($result->getGeneratedValue());

        return $address;
    }

    private function updateAddress(AddressInterface $address)
    {
        $addressData = $this->hydrator->extract($address);
        unset(
            $addressData['member_id'],
            $addressData['contact_id'],
            $addressData['contact_address_id'],
            $addressData['created']
        );
        $addressData['modified'] = date('Y-m-d H:i:s');

        $update = new Update(self::TABLE_NAME);
        $update->set($addressData);
        $update->where([
            'member_id = ?' => $address->getMemberId(),
            'contact_id = ?' => $address->getContactId(),
            'contact_address_id = ?' => $address->getContactAddressId(),
        ]);

        $sql = new Sql($this->db);
        $stmt = $sql->prepareStatementForSqlObject($update);
        $stmt->execute();

        return $address;
    }

}