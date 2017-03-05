<?php

namespace Contact\Entity\Factory;


use Contact\Entity\ContactEmailHydrator;
use Contact\Entity\ContactHydrator;
use Contact\Model\EmailAddressModelInterface;
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

    public function __invoke(EmailAddressModelInterface $emailAddressModel)
    {
        return $this->prepareHydrator($emailAddressModel);
    }

    /**
     * Prepare the hydrator to allow aggregated hydrations
     *
     * @param EmailAddressModelInterface $emailAddressModel
     * @return AggregateHydrator
     */
    public function prepareHydrator(EmailAddressModelInterface $emailAddressModel)
    {
        $this->hydrator = new AggregateHydrator();
        $contactHydrator = new ContactHydrator();

        $this->hydrator->add($contactHydrator);
        $this->hydrator->add(
            new ContactEmailHydrator($emailAddressModel)
        );

        return $this->hydrator;
    }
}