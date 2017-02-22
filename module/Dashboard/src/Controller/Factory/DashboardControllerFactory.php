<?php

namespace Dashboard\Controller\Factory;


use Contact\Model\ContactEmailRepositoryInterface;
use Contact\Model\ContactRepositoryInterface;
use Contact\Model\CountryRepositoryInterface;
use Dashboard\Controller\DashboardController;
use Dashboard\Form\ContactForm;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class DashboardControllerFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new DashboardController(
            $container->get(AuthenticationService::class),
            $container->get(ContactRepositoryInterface::class),
            $container->get(ContactEmailRepositoryInterface::class),
            $container->get(CountryRepositoryInterface::class),
            $container->get('FormElementManager')->get(ContactForm::class)
        );
    }

}