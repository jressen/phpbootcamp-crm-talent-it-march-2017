<?php

namespace Contact\Model;


use Contact\Entity\ContactEmailInterface;

interface ContactEmailCommandInterface
{
    /**
     * Creates a new entry in the backend storage
     *
     * @param ContactEmailInterface $contactEmail
     * @return ContactEmailInterface
     */
    public function insertContactEmail(ContactEmailInterface $contactEmail);

    /**
     * Updates an existing entry in the backend storage
     *
     * @param ContactEmailInterface $contactEmail
     * @return ContactEmailInterface
     */
    public function updateContactEmail(ContactEmailInterface $contactEmail);

    /**
     * Removes an existing entry from the backend storage
     *
     * @param ContactEmailInterface $contactEmail
     * @return bool
     */
    public function deleteContactEmail(ContactEmailInterface $contactEmail);
}