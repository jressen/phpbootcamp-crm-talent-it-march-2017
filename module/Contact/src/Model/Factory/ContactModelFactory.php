<?php

namespace Contact\Model\Factory;


use Contact\Entity\Contact;
use Contact\Model\ContactModel;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\ClassMethods;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class ContactModelFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ContactModel(
            $container->get(AdapterInterface::class),
            new ClassMethods(),
            new Contact()
        );
    }

}