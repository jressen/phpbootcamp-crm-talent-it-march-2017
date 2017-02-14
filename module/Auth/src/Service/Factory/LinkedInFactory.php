<?php

namespace Auth\Service\Factory;


use Application\Module;
use Auth\Entity\MemberEntity;
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
        $guzzleClient = new Client([
            'headers' => [
                'User-Agent' => 'ZFCRM/' . Module::VERSION . ' curl/' . curl_version() . ' PHP/7.1.1',
                'Accept' => 'application/json',
                'x-li-format' => 'json',
            ],
        ]);
        $memberEntity = new MemberEntity(0, '', '');
        $config = $container->get('config');

        return new LinkedIn(
            $guzzleClient,
            $memberEntity,
            $config['linkedin']
        );
    }

}