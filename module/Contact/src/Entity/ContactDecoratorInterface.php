<?php

namespace Contact\Entity;


interface ContactDecoratorInterface
{

    /**
     * @return ContactInterface
     */
    public function getContact();

    /**
     * @return ContactEmailInterface[]
     */
    public function getContactEmails();

    /**
     * @return ContactAddressInterface[]
     */
    public function getContactAddresses();

    /**
     * @return ContactImageInterface[]
     */
    public function getContactImage();
}