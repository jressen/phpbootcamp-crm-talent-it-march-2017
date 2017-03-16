<?php

namespace Contact\Model;


use Contact\Entity\EmailAddressInterface;

interface EmailAddressModelInterface
{
    /**
     * Fetch all email addresses for a given contact ID
     *
     * @param int $contactId
     * @return EmailAddressInterface[]
     * @throws \DomainException
     * @throws \RuntimeException
     */
    public function fetchAllEmailAddresses($contactId);

    /**
     * @param int $contactId
     * @param int $contactEmailId
     * @return EmailAddressInterface
     */
    public function findEmailAddressById($contactId, $contactEmailId);

    /**
     * @return EmailAddressInterface
     */
    public function saveEmailAddress(EmailAddressInterface $emailAddress);

    /**
     * @param int $contactId
     * @param EmailAddressInterface $emailAddress
     * @return bool
     */
    public function deleteEmailAddress($contactId, EmailAddressInterface $emailAddress);
}