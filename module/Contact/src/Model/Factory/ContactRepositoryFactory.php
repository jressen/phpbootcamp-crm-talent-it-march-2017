<?php

namespace Contact\Model\Factory;


use Contact\Entity\ContactEntity;
use Contact\Entity\ContactEntityHydrator;
use Contact\Model\ContactRepository;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Db\Adapter\AdapterInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class ContactRepositoryFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ContactRepository(
            $container->get(AdapterInterface::class),
            $container->get(ContactEntityHydrator::class),
            new ContactEntity(0, 0)
        );
    }

}