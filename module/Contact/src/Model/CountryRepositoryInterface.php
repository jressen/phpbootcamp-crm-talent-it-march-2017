<?php

namespace Contact\Model;

use Contact\Entity\CountryInterface;

interface CountryRepositoryInterface
{
    /**
     * @return CountryInterface[]
     */
    public function getAllCountries();

    /**
     * @param string $countryCode
     * @return CountryInterface
     */
    public function getCountryByCountryCode($countryCode);
}