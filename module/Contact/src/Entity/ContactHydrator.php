<?php

namespace Contact\Entity;


use Contact\Model\EmailAddressModelInterface;
use Zend\Hydrator\HydratorInterface;

class ContactHydrator implements HydratorInterface
{
    /**
     * @inheritDoc
     */
    public function extract($object)
    {
        if (!$object instanceof ContactInterface) {
            return [];
        }

        return [
            'member_id' => $object->getMemberId(),
            'contact_id' => $object->getContactId(),
            'first_name' => $object->getFirstName(),
            'last_name' => $object->getLastName(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof ContactInterface) {
            return $object;
        }

        if ($this->propertyAvailable('member_id', $data)) {
            $object->setMemberId($data['member_id']);
        }

        if ($this->propertyAvailable('contact_id', $data)) {
            $object->setContactId($data['contact_id']);
        }

        if ($this->propertyAvailable('first_name', $data)) {
            $object->setFirstName($data['first_name']);
        }

        if ($this->propertyAvailable('last_name', $data)) {
            $object->setLastName($data['last_name']);
        }

        return $object;
    }

    private function propertyAvailable($property, $data)
    {
        return (array_key_exists($property, $data) && !empty($data[$property]));
    }

}