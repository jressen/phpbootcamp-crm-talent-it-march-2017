<?php

namespace Contact\Entity;


class Country implements CountryInterface
{
    /**
     * @var string
     */
    protected $iso;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $niceName;

    /**
     * @var string
     */
    protected $iso3;

    /**
     * @var int
     */
    protected $numCode;

    /**
     * @var int
     */
    protected $phoneCode;

    /**
     * Country constructor.
     * @param string $iso
     * @param string $name
     * @param string $niceName
     * @param string $iso3
     * @param int $numCode
     * @param int $phoneCode
     */
    public function __construct($iso = '', $name = '', $niceName = '', $iso3 = '', $numCode = 0, $phoneCode = 0)
    {
        $this->iso = $iso;
        $this->name = $name;
        $this->niceName = $niceName;
        $this->iso3 = $iso3;
        $this->numCode = $numCode;
        $this->phoneCode = $phoneCode;
    }

    /**
     * @return string
     */
    public function getIso()
    {
        return $this->iso;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getNiceName()
    {
        return $this->niceName;
    }

    /**
     * @return string
     */
    public function getIso3()
    {
        return $this->iso3;
    }

    /**
     * @return int
     */
    public function getNumCode()
    {
        return $this->numCode;
    }

    /**
     * @return int
     */
    public function getPhoneCode()
    {
        return $this->phoneCode;
    }
}