<?php

namespace Contact\Model;


use Contact\Entity\ContactAddressInterface;

interface ContactAddressRepositoryInterface
{
    /**
     * @param int $contactAddressId
     * @param int $contactId
     * @return ContactAddressInterface
     */
    public function getAddressById($contactAddressId, $contactId);

    /**
     * @param int $contactId
     * @return ContactAddressInterface[]
     */
    public function getAllAddresses($contactId);
}