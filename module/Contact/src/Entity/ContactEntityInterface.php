<?php

namespace Contact\Entity;


interface ContactEntityInterface
{
    /**
     * @return int
     */
    public function getMemberId();

    /**
     * @return int
     */
    public function getContactId();

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @return ContactEmailInterface[]
     */
    public function getEmailAddresses();

    /**
     * @param array $emailAddresses
     * @return ContactEntity
     */
    public function setEmailAddresses($emailAddresses);

    /**
     * @return ContactAddressInterface[]
     */
    public function getAddresses();

    /**
     * @param array $addresses
     * @return ContactEntity
     */
    public function setAddresses($addresses);

    /**
     * @return ContactImageInterface[]
     */
    public function getImages();

    /**
     * @param array $images
     * @return ContactEntity
     */
    public function setImages($images);
}