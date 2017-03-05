<?php

namespace Contact\Entity;


interface ContactAwareInterface extends MemberAwareInterface
{
    /**
     * Retrieve the sequence ID of a Contact entity
     *
     * @return int
     */
    public function getContactId();
}