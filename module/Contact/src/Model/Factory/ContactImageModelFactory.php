<?php

namespace Contact\Model\Factory;


use Contact\Entity\ContactImage;
use Contact\Entity\ContactImageHydrator;
use Contact\Model\ContactImageModel;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Db\Adapter\AdapterInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class ContactImageModelFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ContactImageModel(
            $container->get(AdapterInterface::class),
            new ContactImageHydrator(),
            new ContactImage(0, 0, 0, '')
        );
    }

}