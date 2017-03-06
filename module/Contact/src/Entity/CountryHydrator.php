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

        if ($this->propertyAvailable('iso', $data)) {
            $object->setIso($data['iso']);
        }

        if ($this->propertyAvailable('name', $data)) {
            $object->setName($data['name']);
        }

        if ($this->propertyAvailable('nicename', $data)) {
            $object->setNicename($data['nicename']);
        }

        if ($this->propertyAvailable('iso3', $data)) {
            $object->setIso3($data['iso3']);
        }

        if ($this->propertyAvailable('numcode', $data)) {
            $object->setNumcode($data['numcode']);
        }

        if ($this->propertyAvailable('phonecode', $data)) {
            $object->setPhoneCode($data['phonecode']);
        }

        return $object;
    }

    private function propertyAvailable($property, $data)
    {
        return (array_key_exists($property, $data) && !empty($data[$property]));
    }

}