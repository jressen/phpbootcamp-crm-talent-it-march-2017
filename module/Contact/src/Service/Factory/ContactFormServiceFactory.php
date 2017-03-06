<?php

namespace Contact\Service\Factory;


use Contact\Entity\Address;
use Contact\Entity\AddressHydrator;
use Contact\Entity\Contact;
use Contact\Entity\ContactHydrator;
use Contact\Entity\EmailAddress;
use Contact\Entity\EmailAddressHydrator;
use Contact\Service\ContactFormService;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class ContactFormServiceFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ContactFormService(
            new Contact(),
            new ContactHydrator(),
            new EmailAddress(),
            new EmailAddressHydrator(),
            new Address(),
            new AddressHydrator()
        );
    }

}