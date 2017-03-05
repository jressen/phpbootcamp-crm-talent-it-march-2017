<?php

namespace Contact\Entity;


interface ContactInterface
{
    /**
     * Retrieve the sequence ID from this Contact
     *
     * @return int
     */
    public function getContactId();

    /**
     * Retrieve the member sequence ID from this Contact
     *
     * @return int
     */
    public function getMemberId();

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
}