<?php

namespace Contact\Entity\Factory;


use Contact\Entity\AddressCountryHydrator;
use Contact\Entity\AddressHydrator;
use Contact\Entity\ContactAddressHydrator;
use Contact\Entity\ContactEmailHydrator;
use Contact\Entity\ContactHydrator;
use Contact\Model\AddressModelInterface;
use Contact\Model\CountryModelInterface;
use Contact\Model\EmailAddressModelInterface;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Hydrator\Aggregate\AggregateHydrator;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class AddressHydratorFactory
{
    /**
     * @var AggregateHydrator
     */
    protected $hydrator;

    public function __invoke(
        CountryModelInterface $countryModel
    )
    {
        return $this->prepareHydrator($countryModel);
    }

    /**
     * Prepare the hydrator to allow aggregated hydrations
     *
     * @param CountryModelInterface $countryModel
     * @return AggregateHydrator
     */
    public function prepareHydrator(
        CountryModelInterface $countryModel
    )
    {
        $this->hydrator = new AggregateHydrator();
        $addressHydrator = new AddressHydrator();

        $this->hydrator->add($addressHydrator);
        $this->hydrator->add(
            new AddressCountryHydrator($countryModel)
        );

        return $this->hydrator;
    }
}