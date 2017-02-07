<?php
/**
 * Created by PhpStorm.
 * User: dragonbe
 * Date: 07/02/2017
 * Time: 08:30
 */

namespace Contact\Model;


interface ContactCommandInterface
{
    /**
     * @param Contact $contact
     * @return Contact
     */
    public function insertContact(Contact $contact);

    /**
     * @param Contact $contact
     * @return Contact
     */
    public function updateContact(Contact $contact);

    /**
     * @param Contact $contact
     * @return bool
     */
    public function deleteContact(Contact $contact);
}