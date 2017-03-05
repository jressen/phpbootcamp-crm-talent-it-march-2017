<?php

namespace Contact\Entity;


interface ImageInterface extends ContactAwareInterface
{
    /**
     * @return int
     */
    public function getContactImageId();

    /**
     * @return string
     */
    public function getImageLink();

    /**
     * @return bool
     */
    public function isImageActive();
}