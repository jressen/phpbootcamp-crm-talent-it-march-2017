<?php

namespace Contact\Entity;


interface MemberAwareInterface
{
    /**
     * Retrieve the sequence ID of a Member
     *
     * @return int
     */
    public function getMemberId();
}