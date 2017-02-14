<?php

namespace Contact\Entity;


use Auth\Entity\MemberAwareInterface;

interface ContactEmailInterface extends MemberAwareInterface
{
    /**
     * Retrieve the contact email sequence ID
     *
     * @return int
     */
    public function getContactEmailId();

    /**
     * Retrieve the contact sequence ID
     *
     * @return int
     */
    public function getContactId();

    /**
     * Retrieve the contact email address
     *
     * @return string
     */
    public function getEmailAddress();

    /**
     * Is this email address primary or not?
     *
     * @return bool
     */
    public function isPrimary();
}