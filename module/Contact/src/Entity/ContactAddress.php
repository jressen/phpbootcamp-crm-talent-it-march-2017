<?php

namespace Contact\Entity;


class ContactAddress implements ContactAddressInterface
{
    /**
     * @var int
     */
    protected $contactAddressId;
    /**
     * @var int
     */
    protected $contactId;
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
     * @var string
     */
    protected $countryCode;

    /**
     * ContactAddress constructor.
     * @param int $contactAddressId
     * @param int $contactId
     * @param string $street1
     * @param string $street2
     * @param string $postcode
     * @param string $city
     * @param string $province
     * @param string $countryCode
     */
    public function __construct(
        $contactAddressId, $contactId,
        $street1 = '',
        $street2 = '',
        $postcode = '',
        $city = '',
        $province = '',
        $countryCode = ''
    )
    {
        $this->contactAddressId = $contactAddressId;
        $this->contactId = $contactId;
        $this->street1 = $street1;
        $this->street2 = $street2;
        $this->postcode = $postcode;
        $this->city = $city;
        $this->province = $province;
        $this->countryCode = $countryCode;
    }

    /**
     * @return int
     */
    public function getContactAddressId()
    {
        return $this->contactAddressId;
    }

    /**
     * @return int
     */
    public function getContactId()
    {
        return $this->contactId;
    }

    /**
     * @return string
     */
    public function getStreet1()
    {
        return $this->street1;
    }

    /**
     * @return string
     */
    public function getStreet2()
    {
        return $this->street2;
    }

    /**
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

}