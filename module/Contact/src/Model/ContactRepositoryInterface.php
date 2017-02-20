<?php

namespace Contact\Model;


use Contact\Entity\ContactInterface;
use Zend\Paginator\Paginator;

interface ContactRepositoryInterface
{
    /**
     * Find all contacts
     *
     * @param int $memberId
     * @return Paginator
     */
    public function findAllContacts($memberId);

    /**
     * Retrieve a single contact
     *
     * @param int $id
     * @return ContactInterface
     */
    public function findContact($id);
}