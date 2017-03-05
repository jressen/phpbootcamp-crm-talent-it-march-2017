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
    protected $nicename;

    /**
     * @var string
     */
    protected $iso3;

    /**
     * @var int
     */
    protected $numcode;

    /**
     * @var int
     */
    protected $phonecode;

    /**
     * Country constructor.
     * @param string $iso
     * @param string $name
     * @param string $nicename
     * @param string $iso3
     * @param int $numcode
     * @param int $phonecode
     */
    public function __construct($iso = '', $name = '', $nicename = '', $iso3 = '', $numcode = 0, $phonecode = 0)
    {
        $this->iso = $iso;
        $this->name = $name;
        $this->nicename = $nicename;
        $this->iso3 = $iso3;
        $this->numcode = $numcode;
        $this->phonecode = $phonecode;
    }

    /**
     * @return string
     */
    public function getIso()
    {
        return $this->iso;
    }

    /**
     * @param string $iso
     * @return Country
     */
    public function setIso($iso)
    {
        $this->iso = $iso;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Country
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getNicename()
    {
        return $this->nicename;
    }

    /**
     * @param string $nicename
     * @return Country
     */
    public function setNicename($nicename)
    {
        $this->nicename = $nicename;
        return $this;
    }

    /**
     * @return string
     */
    public function getIso3()
    {
        return $this->iso3;
    }

    /**
     * @param string $iso3
     * @return Country
     */
    public function setIso3($iso3)
    {
        $this->iso3 = $iso3;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumcode()
    {
        return $this->numcode;
    }

    /**
     * @param int $numcode
     * @return Country
     */
    public function setNumcode($numcode)
    {
        $this->numcode = $numcode;
        return $this;
    }

    /**
     * @return int
     */
    public function getPhonecode()
    {
        return $this->phonecode;
    }

    /**
     * @param int $phonecode
     * @return Country
     */
    public function setPhonecode($phonecode)
    {
        $this->phonecode = $phonecode;
        return $this;
    }

}