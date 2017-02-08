<?php

namespace Contact\Model;


use Contact\Entity\ContactEmailInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Hydrator\HydratorInterface;

class ContactEmailRepository implements ContactEmailRepositoryInterface
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
     * @var ContactEmailInterface
     */
    private $contactEmailPrototype;

    /**
     * ContactEmailRepository constructor.
     *
     * @param AdapterInterface $db
     * @param HydratorInterface $hydrator
     * @param ContactEmailInterface $contactEmail
     */
    public function __construct(
        AdapterInterface $db,
        HydratorInterface $hydrator,
        ContactEmailInterface $contactEmail
    )
    {
        $this->db = $db;
        $this->hydrator = $hydrator;
        $this->contactEmailPrototype = $contactEmail;
    }


    /**
     * @inheritDoc
     */
    public function findContactEmailById($contactId, $contactEmailId)
    {
        // TODO: Implement findContactEmailById() method.
    }

    /**
     * @inheritDoc
     */
    public function findContactEmailByEmail($contactId, $contactEmail)
    {
        $sql       = new Sql($this->db);
        $select    = $sql->select('contact_email');
        $select->where([
            'contact_id = ?' => $contactId,
            'email_address = ?' => $contactEmail,
        ]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();

        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            throw new \RuntimeException(sprintf(
                'Failed retrieving contact with identifier "%s" for contact %d; unknown database error.',
                $contactEmail,
                $contactId
            ));
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->contactEmailPrototype);
        $resultSet->initialize($result);

        $contactEmailAddress = $resultSet->current();

        if (! $contactEmailAddress) {
            throw new \InvalidArgumentException(sprintf(
                'Contact email address with for contact with identifier "%s" not found.',
                $contactId
            ));
        }

        return $contactEmailAddress;
    }

    /**
     * @inheritDoc
     */
    public function findAllContactEmails($contactId)
    {
        $sql       = new Sql($this->db);
        $select    = $sql->select('contact_email');
        $select->where(['contact_id = ?' => $contactId]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();

        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            throw new \RuntimeException(sprintf(
                'Failed retrieving contact with identifier "%s"; unknown database error.',
                $contactId
            ));
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->contactEmailPrototype);
        $resultSet->initialize($result);

        $contactEmailAddresses = $resultSet;

        if (! $contactEmailAddresses) {
            throw new \InvalidArgumentException(sprintf(
                'Contact email address with for contact with identifier "%s" not found.',
                $contactId
            ));
        }

        return $contactEmailAddresses;
    }

}