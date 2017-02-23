<?php

namespace Contact\Entity;


interface CountryInterface
{
    /**
     * @return string
     */
    public function getIso();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getNiceName();

    /**
     * @return string
     */
    public function getIso3();

    /**
     * @return int
     */
    public function getNumCode();

    /**
     * @return int
     */
    public function getPhoneCode();
}