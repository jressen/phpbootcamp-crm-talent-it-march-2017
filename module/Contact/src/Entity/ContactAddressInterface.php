<?php

namespace Contact\Entity;


use Auth\Entity\MemberAwareInterface;

interface ContactAddressInterface extends MemberAwareInterface
{
    /**
     * Retrieve the contact address sequence ID
     *
     * @return int
     */
    public function getContactAddressId();

    /**
     * Retrieve the contact sequence ID
     *
     * @return int
     */
    public function getContactId();

    /**
     * Retrieve the first street line
     *
     * @return string
     */
    public function getStreet1();

    /**
     * Retrieve the second street line
     *
     * @return string
     */
    public function getStreet2();

    /**
     * Retrieve the postal code
     *
     * @return string
     */
    public function getPostcode();

    /**
     * Retrieve the city
     *
     * @return string
     */
    public function getCity();

    /**
     * Retrieve the province/state
     *
     * @return string
     */
    public function getProvince();

    /**
     * Retrieve the country code
     *
     * @return string
     */
    public function getCountryCode();
}