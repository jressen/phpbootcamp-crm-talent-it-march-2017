<?php

namespace Contact\Entity;


use Zend\Hydrator\HydratorInterface;

class CountryHydrator implements HydratorInterface
{
    /**
     * @inheritDoc
     */
    public function extract($object)
    {
        if (!$object instanceof CountryInterface) {
            return [];
        }
        return [
            'iso' => $object->getIso(),
            'name' => $object->getName(),
            'nicename' => $object->getNicename(),
            'iso3' => $object->getIso3(),
            'numcode' => $object->getNumcode(),
            'phonecode' => $object->getPhoneCode(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof CountryInterface) {
            return $object;
        }
        $object->setIso($data['iso'])
            ->setName($data['name'])
            ->setNicename($data['nicename'])
            ->setIso3($data['iso3'])
            ->setNumcode($data['numcode'])
            ->setPhoneCode($data['phonecode']);

        return $object;
    }

}