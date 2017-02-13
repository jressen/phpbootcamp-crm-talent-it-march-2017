<?php

namespace Auth\Model\Factory;


use Auth\Model\MemberModel;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Db\Adapter\AdapterInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class MemberModelFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new MemberModel(
            $container->get(AdapterInterface::class),
            $container->get(\Auth\Entity\MemberHydrator::class),
            $container->get(\Auth\Entity\MemberInterface::class)
        );
    }

}