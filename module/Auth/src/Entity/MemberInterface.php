<?php

namespace Auth\Entity;


interface MemberInterface
{
    /**
     * Retrieve the member ID of our application
     *
     * @return int
     */
    public function getMemberId();

    /**
     * Retrieve the LinkedIn id of this member
     *
     * @return string
     */
    public function getLinkedinId();

    /**
     * Retrieve the access token this member used to log in
     *
     * @return string
     */
    public function getAccessToken();
}