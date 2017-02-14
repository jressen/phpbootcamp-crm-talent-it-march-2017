<?php

namespace Auth\Service\Factory;


use Auth\Entity\MemberEntity;
use Auth\Service\MemberService;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class MemberServiceFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new MemberService($container->get(\Auth\Model\MemberModel::class), new MemberEntity(0, '', ''));
    }

}