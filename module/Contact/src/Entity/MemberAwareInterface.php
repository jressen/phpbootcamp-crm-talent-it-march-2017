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

    /**
     * @param $memberId
     * @return int
     */
    public function setMemberId($memberId);
}