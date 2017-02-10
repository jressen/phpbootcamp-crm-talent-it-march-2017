<?php

namespace Auth\Service\Factory;


use Auth\Service\LinkedIn;
use GuzzleHttp\Client;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class LinkedInFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $guzzleClient = new Client();
        $config = $container->get('config');

        return new LinkedIn($guzzleClient, $config['linkedin']);
    }

}