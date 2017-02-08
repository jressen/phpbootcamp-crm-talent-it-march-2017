<?php

namespace Contact\Controller\Factory;

use Contact\Controller\ContactWriteController;
use Contact\Form\ContactForm;
use Contact\Model\ContactCommandInterface;
use Contact\Model\ContactRepositoryInterface;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class ContactWriteControllerFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $formManager = $container->get('FormElementManager');
        return new ContactWriteController(
            $container->get(ContactCommandInterface::class),
            $container->get(ContactRepositoryInterface::class),
            $formManager->get(ContactForm::class)
        );
    }

}