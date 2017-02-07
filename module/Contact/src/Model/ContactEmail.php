<?php

namespace Contact\Model;


class ContactEmail implements ContactEmailInterface
{
    /**
     * @var int
     */
    protected $contactEmailId;

    /**
     * @var int
     */
    protected $contactId;

    /**
     * @var string
     */
    protected $emailAddress;

    /**
     * @var bool
     */
    protected $primary;

    /**
     * ContactEmail constructor.
     *
     * @param int $contactEmailId
     * @param int $contactId
     * @param string $emailAddress
     * @param bool $primary
     */
    public function __construct($contactEmailId, $contactId, $emailAddress, $primary = false)
    {
        $this->contactEmailId = $contactEmailId;
        $this->contactId = $contactId;
        $this->emailAddress = $emailAddress;
        $this->primary = $primary;
    }

    /**
     * @inheritDoc
     */
    public function getContactEmailId()
    {
        return $this->contactEmailId;
    }

    /**
     * @inheritDoc
     */
    public function getContactId()
    {
        return $this->contactId;
    }

    /**
     * @inheritDoc
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @inheritDoc
     */
    public function isPrimary()
    {
        return $this->primary;
    }

}