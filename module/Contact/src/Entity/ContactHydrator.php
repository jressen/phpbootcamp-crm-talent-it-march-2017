<?php

namespace Contact\Entity;


use Zend\Hydrator\AbstractHydrator;
use Zend\Hydrator\HydratorInterface;

class ContactHydrator extends AbstractHydrator implements HydratorInterface
{
    /**
     * @inheritDoc
     */
    public function extract($object)
    {
        return [
            'contact_id' => $object->getContactId(),
            'member_id' => $object->getMemberId(),
            'first_name' => $object->getFirstName(),
            'last_name' => $object->getLastName(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, $object)
    {
        $class = get_class($object);
        return new $class(
            $data['contact_id'],
            $data['member_id'],
            $data['first_name'],
            $data['last_name']
        );
    }

}