<?php

namespace Contact\Entity\Factory;


use Contact\Entity\ContactEntityHydrator;
use Contact\Model\ContactAddressRepositoryInterface;
use Contact\Model\ContactEmailRepositoryInterface;
use Contact\Model\ContactImageModelInterface;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Hydrator\Aggregate\AggregateHydrator;
use Zend\Hydrator\HydratorInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class ContactEntityHydratorFactory implements FactoryInterface
{
    /**
     * @var HydratorInterface
     */
    protected $hydrator;
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return $this->prepareHydrator(
            $container->get(ContactEmailRepositoryInterface::class),
            $container->get(ContactAddressRepositoryInterface::class),
            $container->get(ContactImageModelInterface::class)
        );
    }

    protected function prepareHydrator(
        ContactEmailRepositoryInterface $contactEmailRepository,
        ContactAddressRepositoryInterface $contactAddressRepository,
        ContactImageModelInterface $contactImageModel
    )
    {
        $contactEntityHydrator = new ContactEntityHydrator(
            $contactEmailRepository,
            $contactAddressRepository,
            $contactImageModel
        );
        $this->hydrator = $contactEntityHydrator;
        return $this->hydrator;
    }

}