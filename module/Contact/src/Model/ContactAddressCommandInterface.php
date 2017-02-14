<?php

namespace Contact\Model;


use Contact\Entity\ContactAddressInterface;

interface ContactAddressCommandInterface
{
    /**
     * Stores or updates an instance of Contact Address
     *
     * @param ContactAddressInterface $contactAddress
     * @return ContactAddressInterface
     */
    public function saveContactAddress(ContactAddressInterface $contactAddress);
}