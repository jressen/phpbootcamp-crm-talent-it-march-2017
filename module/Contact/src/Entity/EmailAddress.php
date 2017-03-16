<?php

namespace Contact\Entity;


class EmailAddress implements EmailAddressInterface
{
    /**
     * @var int
     */
    protected $memberId;

    /**
     * @var int
     */
    protected $contactId;

    /**
     * @var int
     */
    protected $contactEmailId;

    /**
     * @var string
     */
    protected $emailAddress;

    /**
     * @var bool
     */
    protected $primary;

    /**
     * EmailAddress constructor.
     * @param int $memberId
     * @param int $contactId
     * @param int $contactEmailId
     * @param string $emailAddress
     * @param bool $primary
     */
    public function __construct($memberId = 0, $contactId = 0, $contactEmailId = 0, $emailAddress = '', $primary = false)
    {
        $this->memberId = $memberId;
        $this->contactId = $contactId;
        $this->contactEmailId = $contactEmailId;
        $this->emailAddress = $emailAddress;
        $this->primary = $primary;
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
     * @return EmailAddress
     */
    public function setMemberId($memberId)
    {
        $this->memberId = (int) $memberId;
        return $this;
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
     * @return EmailAddress
     */
    public function setContactId($contactId)
    {
        $this->contactId = (int) $contactId;
        return $this;
    }

    /**
     * @return int
     */
    public function getContactEmailId()
    {
        return $this->contactEmailId;
    }

    /**
     * @param int $contactEmailId
     * @return EmailAddress
     */
    public function setContactEmailId($contactEmailId)
    {
        $this->contactEmailId = (int) $contactEmailId;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @param string $emailAddress
     * @return EmailAddress
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPrimary()
    {
        return $this->primary;
    }

    /**
     * @param bool $primary
     * @return EmailAddress
     */
    public function setPrimary($primary)
    {
        $this->primary = $primary;
        return $this;
    }
}