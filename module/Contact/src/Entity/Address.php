<?php

namespace Contact\Entity;


class Address implements AddressInterface
{
    /**
     * @var int
     */
    protected $memberId;

    /**
     * @var int
     */
    protected $contactId;

    /**
     * @var int
     */
    protected $contactAddressId;

    /**
     * @var string
     */
    protected $street1;

    /**
     * @var string
     */
    protected $street2;

    /**
     * @var string
     */
    protected $postcode;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $province;

    /**
     * @var CountryInterface
     */
    protected $country;

    /**
     * Address constructor.
     * @param int $memberId
     * @param int $contactId
     * @param int $contactAddressId
     * @param string $street1
     * @param string $street2
     * @param string $postcode
     * @param string $city
     * @param string $province
     */
    public function __construct(
        $memberId = 0,
        $contactId = 0,
        $contactAddressId = 0,
        $street1 = '',
        $street2 = '',
        $postcode = '',
        $city = '',
        $province = ''
    )
    {
        $this->memberId = $memberId;
        $this->contactId = $contactId;
        $this->contactAddressId = $contactAddressId;
        $this->street1 = $street1;
        $this->street2 = $street2;
        $this->postcode = $postcode;
        $this->city = $city;
        $this->province = $province;
    }

    /**
     * @return int
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * @param int $memberId
     * @return Address
     */
    public function setMemberId($memberId)
    {
        $this->memberId = $memberId;
        return $this;
    }

    /**
     * @return int
     */
    public function getContactId()
    {
        return $this->contactId;
    }

    /**
     * @param int $contactId
     * @return Address
     */
    public function setContactId($contactId)
    {
        $this->contactId = $contactId;
        return $this;
    }

    /**
     * @return int
     */
    public function getContactAddressId()
    {
        return $this->contactAddressId;
    }

    /**
     * @param int $contactAddressId
     * @return Address
     */
    public function setContactAddressId($contactAddressId)
    {
        $this->contactAddressId = $contactAddressId;
        return $this;
    }

    /**
     * @return string
     */
    public function getStreet1()
    {
        return $this->street1;
    }

    /**
     * @param string $street1
     * @return Address
     */
    public function setStreet1($street1)
    {
        $this->street1 = $street1;
        return $this;
    }

    /**
     * @return string
     */
    public function getStreet2()
    {
        return $this->street2;
    }

    /**
     * @param string $street2
     * @return Address
     */
    public function setStreet2($street2)
    {
        $this->street2 = $street2;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param string $postcode
     * @return Address
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param string $province
     * @return Address
     */
    public function setProvince($province)
    {
        $this->province = $province;
        return $this;
    }

    /**
     * @return CountryInterface
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param CountryInterface $country
     * @return Address
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }
}