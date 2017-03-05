<?php

namespace Contact\Model;


use Contact\Entity\CountryInterface;

interface CountryModelInterface
{
    /**
     * @return CountryInterface[]
     */
    public function fetchAllCountries();

    /**
     * @param $iso
     * @return CountryInterface
     */
    public function findCountryByIso($iso);
}