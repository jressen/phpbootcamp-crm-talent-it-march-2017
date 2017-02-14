<?php

namespace Auth\Service\Factory;


use Auth\Entity\MemberEntity;
use Auth\Service\MemberService;
use Contact\Entity\Contact;
use Contact\Entity\ContactAddress;
use Contact\Entity\ContactEmail;
use Contact\Entity\ContactImage;
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
        return new MemberService(
            $container->get(\Auth\Model\MemberModel::class),
            new MemberEntity(0, '', ''),
            $container->get(\Contact\Model\ContactCommandInterface::class),
            new Contact(0, 0, '', ''),
            $container->get(\Contact\Model\ContactEmailCommandInterface::class),
            new ContactEmail(0, 0, 0, ''),
            $container->get(\Contact\Model\ContactAddressCommandInterface::class),
            new ContactAddress(0, 0, 0),
            $container->get(\Contact\Model\ContactImageModelInterface::class),
            new ContactImage(0, 0, 0, '')
        );
    }

}