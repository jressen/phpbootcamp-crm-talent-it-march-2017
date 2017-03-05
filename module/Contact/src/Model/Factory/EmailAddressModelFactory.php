<?php

namespace Contact\Model\Factory;


use Contact\Entity\EmailAddress;
use Contact\Entity\EmailAddressHydrator;
use Contact\Model\EmailAddressModel;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\ClassMethods;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class EmailAddressModelFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new EmailAddressModel(
            $container->get(AdapterInterface::class),
            new EmailAddressHydrator(),
            new EmailAddress()
        );
    }

}