<?php

namespace Contact\Model;


interface ContactRepositoryInterface
{
    /**
     * Find all contacts
     *
     * @return ContactInterface[]
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