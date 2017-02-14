<?php

namespace Contact\Entity;


use Zend\Hydrator\HydratorInterface;

class ContactAddressHydrator implements HydratorInterface
{
    /**
     * @inheritDoc
     */
    public function extract($object)
    {
        return [
            'contact_address_id' => $object->getContactAddressId(),
            'member_id' => $object->getMemberId(),
            'contact_id' => $object->getContactId(),
            'street_1' => $object->getStreet1(),
            'street_2' => $object->getStreet2(),
            'postcode' => $object->getPostcode(),
            'city' => $object->getCity(),
            'province' => $object->getProvince(),
            'country_code' => $object->getCountryCode(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, $object)
    {
        $class = get_class($object);
        return new $class(
            $data['contact_address_id'],
            $data['member_id'],
            $data['contact_id'],
            $data['street_1'],
            $data['street_2'],
            $data['postcode'],
            $data['city'],
            $data['province'],
            $data['country_code']
        );
    }

}