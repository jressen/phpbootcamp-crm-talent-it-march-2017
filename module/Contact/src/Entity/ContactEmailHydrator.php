<?php

namespace Contact\Entity;


use Zend\Hydrator\HydratorInterface;

class ContactEmailHydrator implements HydratorInterface
{
    /**
     * @inheritDoc
     */
    public function extract($object)
    {
        /** @var ContactEmail $object */
        return [
            'contact_email_id' => $object->getContactEmailId(),
            'contact_id' => $object->getContactId(),
            'email_address' => $object->getEmailAddress(),
            'primary' => $object->isPrimary(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, $object)
    {
        /** @var ContactEmail $class */
        $class = get_class($object);
        return new $class(
            $data['contact_email_id'],
            $data['contact_id'],
            $data['email_address'],
            (bool) $data['primary']
        );
    }

}