<?php

namespace Contact\Model;


use Contact\Entity\EmailAddressInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Hydrator\HydratorInterface;

class EmailAddressModel implements EmailAddressModelInterface
{
    const TABLE_NAME = 'contact_email';

    /**
     * @var AdapterInterface
     */
    protected $db;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @var EmailAddressInterface
     */
    protected $emailAddressPrototype;

    /**
     * EmailAddressModel constructor.
     * @param AdapterInterface $db
     * @param HydratorInterface $hydrator
     * @param EmailAddressInterface $emailAddressPrototype
     */
    public function __construct(AdapterInterface $db, HydratorInterface $hydrator, EmailAddressInterface $emailAddressPrototype)
    {
        $this->db = $db;
        $this->hydrator = $hydrator;
        $this->emailAddressPrototype = $emailAddressPrototype;
    }

    /**
     * @inheritDoc
     */
    public function fetchAllEmailAddresses($contactId)
    {
        $sql = new Sql($this->db);
        $select = $sql->select(self::TABLE_NAME);
        $select->where(['contact_id = ?' => (int) $contactId]);

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            throw new \DomainException('Cannot find an email address associated with this contact');
        }
        $resultSet = new HydratingResultSet($this->hydrator, $this->emailAddressPrototype);
        $resultSet->initialize($result);

        if (!$resultSet) {
            throw new \RuntimeException('Something was wrong processing your data');
        }

        return $resultSet;
    }

    /**
     * @inheritDoc
     */
    public function findEmailAddressById($contactId, $contactEmailId)
    {
        // TODO: Implement findEmailAddressById() method.
    }

    /**
     * @inheritDoc
     */
    public function saveEmailAddress($contactId, EmailAddressInterface $emailAddress)
    {
        // TODO: Implement saveEmailAddress() method.
    }

    /**
     * @inheritDoc
     */
    public function deleteEmailAddress($contactId, EmailAddressInterface $emailAddress)
    {
        // TODO: Implement deleteEmailAddress() method.
    }

}