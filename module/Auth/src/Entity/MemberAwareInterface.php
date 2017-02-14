<?php

namespace Auth\Entity;


interface MemberAwareInterface
{
    /**
     * Retrieve the registered member ID from this entity
     *
     * @return int
     */
    public function getMemberId();
}