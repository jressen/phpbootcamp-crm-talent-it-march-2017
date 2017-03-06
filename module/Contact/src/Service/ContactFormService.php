<?php

namespace Contact\Service;


use Contact\Entity\AddressInterface;
use Contact\Entity\ContactInterface;
use Contact\Entity\EmailAddressInterface;
use Zend\Hydrator\HydratorInterface;
use Zend\Stdlib\Parameters;

class ContactFormService implements ContactFormServiceInterface
{
    /**
     * @var ContactInterface
     */
    protected $contactPrototype;

    /**
     * @var HydratorInterface
     */
    protected $contactHydrator;

    /**
     * @var EmailAddressInterface
     */
    protected $emailAddressPrototype;

    /**
     * @var HydratorInterface
     */
    protected $emailAddressHydrator;

    /**
     * @var AddressInterface
     */
    protected $addressPrototype;

    /**
     * @var HydratorInterface
     */
    protected $addressHydrator;

    /**
     * ContactFormService constructor.
     * @param ContactInterface $contactPrototype
     * @param HydratorInterface $contactHydrator
     * @param EmailAddressInterface $emailAddressPrototype
     * @param HydratorInterface $emailAddressHydrator
     * @param AddressInterface $addressPrototype
     * @param HydratorInterface $addressHydrator
     */
    public function __construct(ContactInterface $contactPrototype, HydratorInterface $contactHydrator, EmailAddressInterface $emailAddressPrototype, HydratorInterface $emailAddressHydrator, AddressInterface $addressPrototype, HydratorInterface $addressHydrator)
    {
        $this->contactPrototype = $contactPrototype;
        $this->contactHydrator = $contactHydrator;
        $this->emailAddressPrototype = $emailAddressPrototype;
        $this->emailAddressHydrator = $emailAddressHydrator;
        $this->addressPrototype = $addressPrototype;
        $this->addressHydrator = $addressHydrator;
    }

    /**
     * @inheritdoc
     */
    public function processFormData(Parameters $data)
    {
        $contactData = $data->offsetGet('contact-fieldset');
        $contact = $this->contactHydrator->hydrate($contactData, clone $this->contactPrototype);

        $contactEmailCollection = $data->offsetGet('contact-email-collection');
        $emailAddresses = [];
        foreach ($contactEmailCollection as $contactEmailData) {
            $emailAddresses[] = $this->emailAddressHydrator->hydrate($contactEmailData, clone $this->emailAddressPrototype);
        }
        $contact->setEmailAddresses($emailAddresses);

        $addressCollection = $data->offsetGet('contact-address-collection');
        $addresses = [];
        foreach ($addressCollection as $addressData) {
            $addresses[] = $this->addressHydrator->hydrate($addressData, clone $this->addressPrototype);
        }
        $contact->setAddresses($addresses);

        return $contact;
    }
}