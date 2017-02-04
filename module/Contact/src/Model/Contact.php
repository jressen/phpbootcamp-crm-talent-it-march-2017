<?php

namespace Contact\Model;


class Contact
{
    public $contactId;
    public $firstName;
    public $lastName;

    public function exchangeArray(array $data)
    {
        $this->contactId = $data['contact_id'];
        $this->firstName = $data['first_name'];
        $this->lastName = $data['last_name'];
    }
}