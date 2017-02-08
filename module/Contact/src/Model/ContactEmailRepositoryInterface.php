<?php

namespace Contact\Model;


interface ContactEmailRepositoryInterface
{
    /**
     * Find a contact email addres by given contact email address sequence ID
     *
     * @param int $contactId
     * @param int $contactEmailId
     * @return ContactEmailInterface
     */
    public function findContactEmailById($contactId, $contactEmailId);

    /**
     * Find a contact email address by given email address
     *
     * @param int $contactId
     * @param string $contactEmail
     * @return ContactEmailInterface
     */
    public function findContactEmailByEmail($contactId, $contactEmail);

    /**
     * Retrieve all contact email addresses by given contact ID
     * @param int $contactId
     * @return ContactEmailInterface[]
     */
    public function findAllContactEmails($contactId);
}