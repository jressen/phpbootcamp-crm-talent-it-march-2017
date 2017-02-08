<?php

namespace Contact\Model;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;

class ContactCommand implements ContactCommandInterface
{
    /**
     * @var AdapterInterface
     */
    private $db;

    /**
     * ZendDbSqlCommand constructor.
     * @param AdapterInterface $db
     */
    public function __construct(AdapterInterface $db)
    {
        $this->db = $db;
    }

    /**
     * @inheritDoc
     */
    public function insertContact(Contact $contact)
    {
        $date = new \DateTime();
        $insert = new Insert('contact');
        $insert->values([
            'first_name' => $contact->getFirstName(),
            'last_name' => $contact->getLastName(),
            'created' => $date->format('Y-m-d H:i:s'),
            'modified' => $date->format('Y-m-d H:i:s'),
        ]);

        $sql = new Sql($this->db);
        $stmt = $sql->prepareStatementForSqlObject($insert);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException('Database error occurred during contact insert operation');
        }
        $id = $result->getGeneratedValue();
        return new Contact($id, $contact->getFirstName(), $contact->getLastName());
    }

    /**
     * @inheritDoc
     */
    public function updateContact(Contact $contact)
    {
        $date = new \DateTime();
        $update = new Update('contact');
        $update->set([
            'first_name' => $contact->getFirstName(),
            'last_name' => $contact->getLastName(),
            'modified' => $date->format('Y-m-d H:i:s'),
        ]);
        $update->where(['contact_id = ?' => $contact->getContactId()]);

        $sql = new Sql($this->db);
        $stmt = $sql->prepareStatementForSqlObject($update);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException('Database error occurred during contact update operation');
        }

        return $contact;
    }

    /**
     * @inheritDoc
     */
    public function deleteContact(Contact $contact)
    {
        $delete = new Delete('contact');
        $delete->where(['contact_id = ?' => $contact->getContactId()]);
        $sql = new Sql($this->db);
        $stmt = $sql->prepareStatementForSqlObject($delete);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface) {
            return false;
        }
        return true;
    }

}