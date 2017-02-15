<?php

namespace Contact\Model\Factory;


use Contact\Entity\ContactEmail;
use Contact\Entity\ContactEmailHydrator;
use Contact\Model\ContactEmailRepository;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\Reflection as ReflectionHydrator;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class ContactEmailRepositoryFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ContactEmailRepository(
            $container->get(AdapterInterface::class),
            new ContactEmailHydrator(),
            new ContactEmail(0, 0, 0, '')
        );
    }

}