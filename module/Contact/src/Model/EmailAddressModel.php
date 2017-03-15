<?php

namespace Contact\Model;


use Contact\Entity\EmailAddressInterface;
use Zend\Authentication\Adapter\DbTable\Exception\InvalidArgumentException;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
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
    public function saveEmailAddress(EmailAddressInterface $emailAddress)
    {
        if (0 < (int) $emailAddress->getContactEmailId()) {
            return $this->updateEmailAddress($emailAddress);
        }
        return $this->insertEmailAddress($emailAddress);
    }

    /**
     * @inheritDoc
     */
    public function deleteEmailAddress($contactId, EmailAddressInterface $emailAddress)
    {
        // TODO: Implement deleteEmailAddress() method.
    }

    private function updateEmailAddress(EmailAddressInterface $emailAddress)
    {
        $memberId = $emailAddress->getMemberId();
        $contactId = $emailAddress->getContactId();

        $emailAddressData = $this->hydrator->extract($emailAddress);
        unset (
            $emailAddressData['member_id'],
            $emailAddressData['contact_id'],
            $emailAddressData['contact_email_id']);

        $update = new Update(self::TABLE_NAME);
        $update->set($emailAddressData);
        $update->where([
            'member_id' => $memberId,
            'contact_id' => $contactId,
            'contact_email_id' => $emailAddress->getContactEmailId(),
        ]);

        $sql = new Sql($this->db);
        $stmt = $sql->prepareStatementForSqlObject($update);
        $stmt->execute();

        return $emailAddress;
    }

    /**
     * Store a new email address in the database backend
     *
     * @param EmailAddressInterface $emailAddress
     * @return EmailAddressInterface
     * @throws \RuntimeException
     */
    private function insertEmailAddress(EmailAddressInterface $emailAddress)
    {
        $memberId = $emailAddress->getMemberId();
        $contactId = $emailAddress->getContactId();

        $date = date('Y-m-d H:i:s');
        $emailAddressData = $this->hydrator->extract($emailAddress);
        unset (
            $emailAddressData['contact_email_id']
        );
        $emailAddressData['created'] = $emailAddressData['modified'] = $date;

        $insert = new Insert(self::TABLE_NAME);
        $insert->values($emailAddressData);

        $sql = new Sql($this->db);
        $stmt = $sql->prepareStatementForSqlObject($insert);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException('Cannot process data correctly');
        }

        $id = $result->getGeneratedValue();
        $emailAddress->setContactEmailId($id);
        return $emailAddress;
    }
}