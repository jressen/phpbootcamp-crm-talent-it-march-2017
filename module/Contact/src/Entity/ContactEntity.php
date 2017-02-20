<?php

namespace Contact\Entity;


class ContactEntity implements ContactEntityInterface
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
     * @var string
     */
    protected $firstName;
    /**
     * @var string
     */
    protected $lastName;
    /**
     * @var ContactEmailInterface[]
     */
    protected $emailAddresses;
    /**
     * @var ContactAddressInterface[]
     */
    protected $addresses;
    /**
     * @var ContactImageInterface[]
     */
    protected $images;

    /**
     * ContactEntity constructor.
     *
     * @param int $memberId
     * @param int $contactId
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct($memberId, $contactId, $firstName = '', $lastName = '')
    {
        $this->memberId = $memberId;
        $this->contactId = $contactId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * @inheritdoc
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * @inheritdoc
     */
    public function getContactId()
    {
        return $this->contactId;
    }

    /**
     * @inheritdoc
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @inheritdoc
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @inheritdoc
     */
    public function getEmailAddresses()
    {
        return $this->emailAddresses;
    }

    /**
     * @inheritdoc
     */
    public function setEmailAddresses($emailAddresses)
    {
        $this->emailAddresses = $emailAddresses;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAddresses()
    {
        if (is_null($this->addresses)) {
            $this->addresses = new \SplObjectStorage();
        }
        return $this->addresses;
    }

    /**
     * @inheritdoc
     */
    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @inheritdoc
     */
    public function setImages($images)
    {
        $this->images = $images;
        return $this;
    }
}