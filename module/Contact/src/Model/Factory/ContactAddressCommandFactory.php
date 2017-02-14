<?php

namespace Contact\Model\Factory;


use Contact\Entity\ContactAddress;
use Contact\Entity\ContactAddressHydrator;
use Contact\Model\ContactAddressCommand;
use Contact\Model\ContactAddressRepository;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Db\Adapter\AdapterInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class ContactAddressCommandFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ContactAddressCommand(
            $container->get(AdapterInterface::class),
            new ContactAddressHydrator(),
            new ContactAddress(0, 0, 0)
        );
    }

}