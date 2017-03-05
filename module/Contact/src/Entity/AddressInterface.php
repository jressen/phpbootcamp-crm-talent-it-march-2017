<?php

namespace Contact\Entity;


interface AddressInterface extends ContactAwareInterface
{
    /**
     * @return int
     */
    public function getContactAddressId();

    /**
     * @return string
     */
    public function getStreet1();

    /**
     * @return string
     */
    public function getStreet2();

    /**
     * @return string
     */
    public function getPostCode();

    /**
     * @return string
     */
    public function getCity();

    /**
     * @return string
     */
    public function getProvince();

    /**
     * @return CountryInterface
     */
    public function getCountry();
}