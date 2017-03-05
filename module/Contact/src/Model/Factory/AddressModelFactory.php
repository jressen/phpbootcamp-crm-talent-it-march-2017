<?php

namespace Contact\Model\Factory;


use Contact\Entity\Address;
use Contact\Entity\AddressCountryHydrator;
use Contact\Entity\Factory\AddressHydratorFactory;
use Contact\Model\AddressModel;
use Contact\Model\CountryModelInterface;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\ClassMethods;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class AddressModelFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $countryModel = $container->get(CountryModelInterface::class);
        $addressHydratorFactory = new AddressHydratorFactory();
        $addressHydrator = $addressHydratorFactory->prepareHydrator($countryModel);

        return new AddressModel(
            $container->get(AdapterInterface::class),
            $addressHydrator,
            new Address()
        );
    }

}