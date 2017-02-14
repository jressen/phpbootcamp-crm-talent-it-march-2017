<?php

namespace Contact\Model;


use Contact\Entity\ContactAddressInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
use Zend\Form\Element\DateTime;
use Zend\Hydrator\HydratorInterface;

class ContactAddressCommand implements ContactAddressCommandInterface
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
     * @inheritdoc
     */
    public function saveContactAddress(ContactAddressInterface $contactAddress)
    {
        if (0 < (int) $contactAddress->getContactAddressId()) {
            return $this->updateContactAddress($contactAddress);
        }
        return $this->insertContactAddress($contactAddress);
    }

    /**
     * Stores a new instance of Contact Address
     *
     * @param ContactAddressInterface $contactAddress
     * @return ContactAddressInterface
     */
    private function insertContactAddress(ContactAddressInterface $contactAddress)
    {
        $date = new \DateTime();
        $contactAddressData = $this->hydrator->extract($contactAddress);
        $contactAddressData['created'] = $date->format('Y-m-d H:i:s');
        $contactAddressData['modified'] = $date->format('Y-m-d H:i:s');
        unset ($contactAddressData['contact_address_id']);

        $insert = new Insert('contact_address');
        $insert->values($contactAddressData);

        $sql = new Sql($this->db);
        $stmt = $sql->prepareStatementForSqlObject($insert);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException('Could not store details in backend storage');
        }
        $id = (int) $result->getGeneratedValue();
        $contactAddressClass = get_class($this->contactAddressPrototype);
        return new $contactAddressClass(
            $id,
            $contactAddress->getMemberId(),
            $contactAddress->getContactId(),
            $contactAddress->getStreet1(),
            $contactAddress->getStreet2(),
            $contactAddress->getPostcode(),
            $contactAddress->getCity(),
            $contactAddress->getProvince(),
            $contactAddress->getCountryCode()
        );
    }

    /**
     * Updates an existing instance of Contact Address
     *
     * @param ContactAddressInterface $contactAddress
     * @return ContactAddressInterface
     */
    private function updateContactAddress(ContactAddressInterface $contactAddress)
    {
        $date = new \DateTime();
        $contactAddressData = $this->hydrator->extract($contactAddress);
        $contactAddressData['modified'] = $date->format('Y-m-d H:i:s');
        unset ($contactAddressData['contact_address_id']);

        $update = new Update('contact_address');
        $update->set($contactAddressData);

        $sql = new Sql($this->db);
        $stmt = $sql->prepareStatementForSqlObject($update);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException('Could not store details in backend storage');
        }
        return $contactAddress;
    }

}