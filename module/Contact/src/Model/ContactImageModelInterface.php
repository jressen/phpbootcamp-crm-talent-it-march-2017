<?php

namespace Contact\Model;


use Contact\Entity\ContactImageInterface;
use Zend\Db\ResultSet\ResultSet;

interface ContactImageModelInterface
{
    /**
     * Stores a new or updates an existing contact image object
     *
     * @param ContactImageInterface $contactImage
     * @return ContactImageInterface
     */
    public function saveContactImage(ContactImageInterface $contactImage);

    /**
     * Retrieves Images by provided contact ID
     * @param $contactId
     * @return ResultSet
     * @throws \InvalidArgumentException
     */
    public function findImagesByContactId($contactId);
}