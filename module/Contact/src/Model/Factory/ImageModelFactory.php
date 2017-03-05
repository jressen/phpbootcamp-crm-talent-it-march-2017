<?php

namespace Contact\Model\Factory;


use Contact\Entity\Image;
use Contact\Entity\ImageHydrator;
use Contact\Model\ImageModel;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Db\Adapter\AdapterInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class ImageModelFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ImageModel(
            $container->get(AdapterInterface::class),
            new ImageHydrator(),
            new Image()
        );
    }

}