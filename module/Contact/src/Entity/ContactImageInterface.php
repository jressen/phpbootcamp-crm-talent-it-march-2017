<?php

namespace Contact\Entity;


interface ContactImageInterface
{
    /**
     * Retrieve the contact image sequence ID
     *
     * @return int
     */
    public function getContactImageId();

    /**
     * Retrieve the member sequence ID
     *
     * @return int
     */
    public function getMemberId();

    /**
     * Retrieve the contact sequence ID
     *
     * @return int
     */
    public function getContactId();

    /**
     * Retrieve the link to the profile image
     *
     * @return string
     */
    public function getImageLink();

    /**
     * Check to see if this image is active or not
     *
     * @return bool
     */
    public function isImageActive();
}