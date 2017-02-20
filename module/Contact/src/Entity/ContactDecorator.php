<?php

namespace Contact\Entity;


class ContactDecorator implements ContactDecoratorInterface
{
    /**
     * @var ContactInterface
     */
    protected $contact;
    /**
     * @var ContactEmailInterface[]
     */
    protected $contactEmails;
    /**
     * @var ContactAddressInterface[]
     */
    protected $contactAddresses;
    /**
     * @var ContactImageInterface[]
     */
    protected $contactImage;

    /**
     * ContactDecorator constructor.
     * @param ContactInterface $contact
     * @param ContactEmailInterface[] $contactEmails
     * @param ContactAddressInterface[] $contactAddresses
     * @param ContactImageInterface[] $contactImage
     */
    public function __construct(
        ContactInterface $contact,
        array $contactEmails,
        array $contactAddresses,
        array $contactImage
    )
    {
        $this->contact = $contact;
        $this->contactEmails = $contactEmails;
        $this->contactAddresses = $contactAddresses;
        $this->contactImage = $contactImage;
    }

    /**
     * @return ContactInterface
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @return ContactEmailInterface[]
     */
    public function getContactEmails()
    {
        return $this->contactEmails;
    }

    /**
     * @return ContactAddressInterface[]
     */
    public function getContactAddresses()
    {
        return $this->contactAddresses;
    }

    /**
     * @return ContactImageInterface[]
     */
    public function getContactImage()
    {
        return $this->contactImage;
    }
}