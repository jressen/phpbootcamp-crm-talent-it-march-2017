<?php

namespace Contact\Model;

use Contact\Entity\ContactEmail;
use Contact\Entity\ContactEmailInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;

class ContactEmailCommand implements ContactEmailCommandInterface
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
    public function insertContactEmail(ContactEmailInterface $contactEmail)
    {
        $date = new \DateTime();
        $insert = new Insert('contact_email');
        $insert->values([
            'member_id' => $contactEmail->getMemberId(),
            'contact_id' => $contactEmail->getContactId(),
            'email_address' => $contactEmail->getEmailAddress(),
            'primary' => $contactEmail->isPrimary() ? 1 : 0,
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
        return new ContactEmail(
            $id,
            $contactEmail->getMemberId(),
            $contactEmail->getContactId(),
            $contactEmail->getEmailAddress(),
            $contactEmail->isPrimary()
        );
    }

    /**
     * @inheritDoc
     */
    public function updateContactEmail(ContactEmailInterface $contactEmail)
    {
        $date = new \DateTime();
        $update = new Update('contact_email');
        $update->set([
            'member_id' => $contactEmail->getMemberId(),
            'contact_id' => $contactEmail->getContactId(),
            'email_address' => $contactEmail->getEmailAddress(),
            'primary' => $contactEmail->isPrimary() ? 1 : 0,
            'modified' => $date->format('Y-m-d H:i:s'),
        ]);
        $update->where(['contact_email_id = ?' => $contactEmail->getContactEmailId()]);

        $sql = new Sql($this->db);
        $stmt = $sql->prepareStatementForSqlObject($update);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException('Database error occurred during contact update operation');
        }

        return $contactEmail;
    }

    /**
     * @inheritDoc
     */
    public function deleteContactEmail(ContactEmailInterface $contactEmail)
    {
        $delete = new Delete('contact_email');
        $delete->where(['contact_email_id = ?' => $contactEmail->getContactEmailId()]);
        $sql = new Sql($this->db);
        $stmt = $sql->prepareStatementForSqlObject($delete);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface) {
            return false;
        }
        return true;
    }

}