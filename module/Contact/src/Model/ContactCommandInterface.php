<?php
/**
 * Created by PhpStorm.
 * User: dragonbe
 * Date: 07/02/2017
 * Time: 08:30
 */

namespace Contact\Model;


use Contact\Entity\ContactInterface;

interface ContactCommandInterface
{
    /**
     * @param ContactInterface $contact
     * @return ContactInterface
     */
    public function insertContact(ContactInterface $contact);

    /**
     * @param ContactInterface $contact
     * @return ContactInterface
     */
    public function updateContact(ContactInterface $contact);

    /**
     * @param ContactInterface $contact
     * @return bool
     */
    public function deleteContact(ContactInterface $contact);
}