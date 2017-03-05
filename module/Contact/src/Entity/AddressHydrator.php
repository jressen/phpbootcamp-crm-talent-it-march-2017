<?php

namespace Contact\Entity;


use Zend\Hydrator\HydratorInterface;

class AddressHydrator implements HydratorInterface
{
    /**
     * @inheritDoc
     */
    public function extract($object)
    {
        if (!$object instanceof AddressInterface) {
            return [];
        }
        return [
            'contact_address_id' => $object->getContactAddressId(),
            'member_id' => $object->getMemberId(),
            'contact_id' => $object->getContactId(),
            'street1' => $object->getStreet1(),
            'street2' => $object->getStreet2(),
            'postcode' => $object->getPostCode(),
            'city' => $object->getCity(),
            'province' => $object->getProvince(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof AddressInterface) {
            return $object;
        }

        if ($this->propertyAvailable('contact_address_id', $data)) {
            $object->setContactAddressId($data['contact_address_id']);
        }

        if ($this->propertyAvailable('member_id', $data)) {
            $object->setMemberId($data['member_id']);
        }

        if ($this->propertyAvailable('contact_id', $data)) {
            $object->setContactId($data['contact_id']);
        }

        if ($this->propertyAvailable('street_1', $data)) {
            $object->setStreet1($data['street_1']);
        }

        if ($this->propertyAvailable('street_2', $data)) {
            $object->setStreet2($data['street_2']);
        }

        if ($this->propertyAvailable('postcode', $data)) {
            $object->setPostcode($data['postcode']);
        }

        if ($this->propertyAvailable('city', $data)) {
            $object->setCity($data['city']);
        }

        if ($this->propertyAvailable('province', $data)) {
            $object->setProvince($data['province']);
        }

        return $object;
    }

    private function propertyAvailable($property, $data)
    {
        return (array_key_exists($property, $data) && !empty($data[$property]));
    }

}