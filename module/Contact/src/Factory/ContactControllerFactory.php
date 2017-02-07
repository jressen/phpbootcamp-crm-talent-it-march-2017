<?php

namespace Contact\Factory;


use Contact\Controller\ContactController;
use Contact\Form\ContactForm;
use Contact\Model\ContactRepositoryInterface;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class ContactControllerFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ContactController(
            $container->get(ContactRepositoryInterface::class)
        );
    }

}