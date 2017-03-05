<?php

namespace Contact\Entity;


use Contact\Model\CountryModelInterface;
use Zend\Hydrator\HydratorInterface;

class AddressCountryHydrator implements HydratorInterface
{
    /**
     * @var CountryModelInterface
     */
    protected $countryModel;

    /**
     * AddressCountryHydrator constructor.
     * @param CountryModelInterface $countryModel
     */
    public function __construct(CountryModelInterface $countryModel)
    {
        $this->countryModel = $countryModel;
    }

    /**
     * @inheritDoc
     */
    public function extract($object)
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof AddressInterface) {
            return $object;
        }

        if ($this->propertyAvailable('country_code', $data)) {
            $object->setCountry(
                $this->countryModel->findCountryByIso($data['country_code'])
            );
        }

        return $object;
    }

    private function propertyAvailable($property, $data)
    {
        return (array_key_exists($property, $data) && !empty($data[$property]));
    }

}