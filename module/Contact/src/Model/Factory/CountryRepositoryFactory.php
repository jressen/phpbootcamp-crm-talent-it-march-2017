<?php

namespace Contact\Model\Factory;


use Contact\Entity\Country;
use Contact\Entity\CountryHydrator;
use Contact\Model\CountryRepository;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Db\Adapter\AdapterInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class CountryRepositoryFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new CountryRepository(
            $container->get(AdapterInterface::class),
            new CountryHydrator(),
            new Country()
        );
    }

}