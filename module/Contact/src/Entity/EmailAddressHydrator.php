<?php

namespace Contact\Entity;


use Contact\Model\EmailAddressModelInterface;
use Zend\Hydrator\HydratorInterface;

class EmailAddressHydrator implements HydratorInterface
{
    /**
     * @inheritDoc
     */
    public function extract($object)
    {
        if (!$object instanceof EmailAddressInterface) {
            return [];
        }
        return [
            'member_id' => $object->getMemberId(),
            'contact_id' => $object->getContactId(),
            'contact_email_id' => $object->getContactEmailId(),
            'email_address' => $object->getEmailAddress(),
            'primary' => (int) $object->isPrimary(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof EmailAddressInterface) {
            return $object;
        }

        if ($this->propertyAvailable('member_id', $data)) {
            $object->setMemberId($data['member_id']);
        }

        if ($this->propertyAvailable('contact_id', $data)) {
            $object->setContactId($data['contact_id']);
        }

        if ($this->propertyAvailable('contact_email_id', $data)) {
            $object->setContactEmailId($data['contact_email_id']);
        }

        if ($this->propertyAvailable('email_address', $data)) {
            $object->setEmailAddress($data['email_address']);
        }

        if ($this->propertyAvailable('primary', $data)) {
            $primary = (1 === (int) $data['primary']);
            $object->setPrimary($primary);
        }

        return $object;
    }

    private function propertyAvailable($property, $data)
    {
        return (array_key_exists($property, $data) && !empty($data[$property]));
    }

}