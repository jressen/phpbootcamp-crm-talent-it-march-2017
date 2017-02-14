<?php

namespace Contact\Entity;


use Auth\Entity\MemberAwareInterface;

interface ContactInterface extends MemberAwareInterface
{
    /**
     * Retrieve the sequence ID of the Contact
     *
     * @return int
     */
    public function getContactId();

    /**
     * Retrieve the first name of the contact
     *
     * @return string
     */
    public function getFirstName();

    /**
     * Retrieve the last name of the contact
     *
     * @return string
     */
    public function getLastName();
}