<?php

namespace Contact\Entity\Factory;


use Contact\Entity\ContactAddressHydrator;
use Contact\Entity\ContactEmailHydrator;
use Contact\Entity\ContactHydrator;
use Contact\Entity\ContactImageHydrator;
use Contact\Model\AddressModelInterface;
use Contact\Model\EmailAddressModelInterface;
use Contact\Model\ImageModelInterface;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Hydrator\Aggregate\AggregateHydrator;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class ContactHydratorFactory
{
    /**
     * @var AggregateHydrator
     */
    protected $hydrator;

    public function __invoke(
        EmailAddressModelInterface $emailAddressModel,
        AddressModelInterface $addressModel,
        ImageModelInterface $imageModel
    )
    {
        return $this->prepareHydrator(
            $emailAddressModel,
            $addressModel,
            $imageModel
        );
    }

    /**
     * Prepare the hydrator to allow aggregated hydrations
     *
     * @param EmailAddressModelInterface $emailAddressModel
     * @return AggregateHydrator
     */
    public function prepareHydrator(
        EmailAddressModelInterface $emailAddressModel,
        AddressModelInterface $addressModel,
        ImageModelInterface $imageModel
    )
    {
        $this->hydrator = new AggregateHydrator();
        $contactHydrator = new ContactHydrator();

        $this->hydrator->add($contactHydrator);
        $this->hydrator->add(
            new ContactEmailHydrator($emailAddressModel)
        );
        $this->hydrator->add(
            new ContactAddressHydrator($addressModel)
        );
        $this->hydrator->add(
            new ContactImageHydrator($imageModel)
        );

        return $this->hydrator;
    }
}