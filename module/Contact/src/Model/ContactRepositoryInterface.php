<?php

namespace Contact\Model;


use Contact\Entity\ContactInterface;
use Zend\Paginator\Paginator;

interface ContactRepositoryInterface
{
    /**
     * Find all contacts
     *
     * @return Paginator
     */
    public function findAllContacts();

    /**
     * Retrieve a single contact
     *
     * @param int $id
     * @return ContactInterface
     */
    public function findContact($id);
}