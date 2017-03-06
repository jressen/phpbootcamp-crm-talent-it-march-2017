<?php

namespace Contact\Entity;


interface ContactInterface extends ContactAwareInterface
{
    /**
     * Retrieve the first name from this Contact
     *
     * @return string
     */
    public function getFirstName();

    /**
     * Retrieve the last name from this Contact
     *
     * @return string
     */
    public function getLastName();

    /**
     * Retrieve all linked email addresses from this Contact
     *
     * @return EmailAddressInterface[]
     */
    public function getEmailAddresses();

    /**
     * Retrieve all linked addresses from this Contact
     *
     * @return AddressInterface[]
     */
    public function getAddresses();
}