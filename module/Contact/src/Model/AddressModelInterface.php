<?php

namespace Contact\Model;


use Contact\Entity\AddressInterface;

interface AddressModelInterface
{
    /**
     * @param int $contactId
     * @return AddressInterface[]
     */
    public function fetchAllAddresses($contactId);

    /**
     * @param int $contactId
     * @param int $contactAddressId
     * @return AddressInterface
     */
    public function findAddressById($contactId, $contactAddressId);

    /**
     * @param AddressInterface $address
     * @return AddressInterface
     */
    public function saveAddress(AddressInterface $address);

    /**
     * @param AddressInterface $address
     * @return bool
     */
    public function deleteAddress(AddressInterface $address);
}