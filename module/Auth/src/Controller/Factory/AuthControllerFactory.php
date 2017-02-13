<?php

namespace Auth\Controller\Factory;


use Auth\Controller\AuthController;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Session\Container;

class AuthControllerFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $sessionContainer = new Container('linkedin');
        $linkedInService = $container->get(\Auth\Service\LinkedIn::class);
        return new AuthController($sessionContainer, $linkedInService);
    }

}