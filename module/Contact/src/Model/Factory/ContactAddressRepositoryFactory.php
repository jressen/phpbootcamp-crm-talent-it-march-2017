<?php

namespace Contact\Model\Factory;


use Contact\Entity\ContactAddress;
use Contact\Entity\ContactAddressHydrator;
use Contact\Model\ContactAddressRepository;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Db\Adapter\AdapterInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class ContactAddressRepositoryFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ContactAddressRepository(
            $container->get(AdapterInterface::class),
            new ContactAddressHydrator(),
            new ContactAddress(0, 0)
        );
    }

}