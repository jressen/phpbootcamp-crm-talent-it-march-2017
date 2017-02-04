<?php

namespace Contact\Model;


use Zend\Db\TableGateway\TableGatewayInterface;

class ContactTable
{
    /**
     * @var TableGatewayInterface
     */
    protected $tableGateway;

    /**
     * ContactTable constructor.
     * @param TableGatewayInterface $tableGateway
     */
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getContact($contactId)
    {
        $id = (int) $contactId;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new \RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveContact(Contact $contact)
    {
        $date = new \DateTime();
        $data = [
            'first_name' => $contact->firstName,
            'last_name' => $contact->lastName,
            'modified' => $date->format('Y-m-d H:i:s'),
        ];

        $id = (int) $contact->contactId;

        if ($id === 0) {
            $data['created'] = $date->format('Y-m-d H:i:s');
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getContact($id)) {
            throw new \RuntimeException(sprintf(
                'Cannot update album with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['contact_id' => $id]);
    }

    public function deleteContact($contactId)
    {
        $this->tableGateway->delete(['contact_id' => (int) $contactId]);
    }
}