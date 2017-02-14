<?php

namespace Contact\Model;


use Contact\Entity\ContactImageInterface;

interface ContactImageModelInterface
{
    /**
     * Stores a new or updates an existing contact image object
     *
     * @param ContactImageInterface $contactImage
     * @return ContactImageInterface
     */
    public function saveContactImage(ContactImageInterface $contactImage);
}