<?php

namespace Contact\Entity;


class Contact implements ContactInterface
{
    /**
     * @var int
     */
    protected $contactId;

    /**
     * @var int
     */
    protected $memberId;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var array
     */
    protected $emailAddresses = [];

    /**
     * @var array
     */
    protected $addresses = [];

    /**
     * @var array
     */
    protected $phoneNumbers = [];

    /**
     * @var array
     */
    protected $images = [];

    /**
     * Contact constructor.
     * @param int $contactId
     * @param int $memberId
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct($contactId = 0, $memberId = 0, $firstName = '', $lastName = '')
    {
        $this->contactId = $contactId;
        $this->memberId = $memberId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * @return int
     */
    public function getContactId()
    {
        return $this->contactId;
    }

    /**
     * @param int $contactId
     * @return Contact
     */
    public function setContactId($contactId)
    {
        $this->contactId = $contactId;
        return $this;
    }

    /**
     * @return int
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * @param int $memberId
     * @return Contact
     */
    public function setMemberId($memberId)
    {
        $this->memberId = $memberId;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return Contact
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return Contact
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return array
     */
    public function getEmailAddresses()
    {
        return $this->emailAddresses;
    }

    /**
     * @param array $emailAddresses
     * @return Contact
     */
    public function setEmailAddresses($emailAddresses)
    {
        $this->emailAddresses = $emailAddresses;
        return $this;
    }

}