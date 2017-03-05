<?php

namespace Contact\Model;


use Contact\Entity\ContactInterface;
use Zend\Paginator\Paginator;

interface ContactModelInterface
{
    /**
     * Fetch all contacts related to given member ID
     *
     * @param int $memberId
     * @return Paginator
     */
    public function fetchAllContacts($memberId);

    /**
     * Find a specific contact with given member and contact ID
     *
     * @param int $memberId
     * @param int $contactId
     * @return ContactInterface
     */
    public function findContact($memberId, $contactId);

    /**
     * Save a contact into the backend
     *
     * @param int $memberId
     * @param ContactInterface $contact
     * @return ContactInterface
     */
    public function saveContact($memberId, ContactInterface $contact);

    /**
     * Remove a given contact
     *
     * @param int $memberId
     * @param ContactInterface $contact
     * @return bool
     */
    public function deleteContact($memberId, ContactInterface $contact);
}