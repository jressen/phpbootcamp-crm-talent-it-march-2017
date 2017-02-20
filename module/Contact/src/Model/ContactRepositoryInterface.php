<?php

namespace Contact\Model;


use Contact\Entity\ContactEntityInterface;
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
     * @return ContactEntityInterface
     */
    public function findContact($id);
}