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
    public function getNicename();

    /**
     * @return string
     */
    public function getIso3();

    /**
     * @return int
     */
    public function getNumcode();

    /**
     * @return int
     */
    public function getPhoneCode();
}