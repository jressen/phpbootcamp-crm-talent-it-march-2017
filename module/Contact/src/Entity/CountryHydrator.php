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
            return $object;
        }
        return [
            'iso' => $object->getIso(),
            'name' => $object->getName(),
            'nicename' => $object->getNiceName(),
            'iso3' => $object->getIso3(),
            'numcode' => $object->getNumCode(),
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
        $objectClass = get_class($object);
        return new $objectClass(
            $data['iso'],
            $data['name'],
            $data['nicename'],
            $data['iso3'],
            $data['numcode'],
            $data['phonecode']
        );
    }

}