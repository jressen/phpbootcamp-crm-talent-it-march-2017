<?php

namespace Contact\Entity;


use Contact\Model\ContactAddressRepositoryInterface;
use Contact\Model\ContactEmailRepositoryInterface;
use Contact\Model\ContactImageModelInterface;
use Zend\Hydrator\HydratorInterface;

class ContactEntityHydrator implements HydratorInterface
{
    /**
     * @var ContactEmailRepositoryInterface
     */
    protected $contactEmailRepository;

    /**
     * @var ContactAddressRepositoryInterface
     */
    protected $contactAddressRepository;

    /**
     * @var ContactImageModelInterface;
     */
    protected $contactImageRepository;

    /**
     * ContactEntityHydrator constructor.
     * @param ContactEmailRepositoryInterface $contactEmailRepository
     * @param ContactAddressRepositoryInterface $contactAddressRepository
     * @param ContactImageModelInterface $contactImageRepository
     */
    public function __construct(
        ContactEmailRepositoryInterface $contactEmailRepository,
        ContactAddressRepositoryInterface $contactAddressRepository,
        ContactImageModelInterface $contactImageRepository
    )
    {
        $this->contactEmailRepository = $contactEmailRepository;
        $this->contactAddressRepository = $contactAddressRepository;
        $this->contactImageRepository = $contactImageRepository;
    }

    /**
     * @inheritDoc
     */
    public function extract($object)
    {
        // TODO: Implement extract() method.
    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof ContactEntityInterface) {
            return $object;
        }
        $class = get_class($object);

        /** @var ContactEntityInterface $object */
        $object = new $class(
            $data['member_id'],
            $data['contact_id'],
            $data['first_name'],
            $data['last_name']
        );

        if ($this->propertyAvailable('contact_id', $data)) {
            $object->setEmailAddresses($this->contactEmailRepository->findAllContactEmails($data['contact_id']));
            $object->setAddresses($this->contactAddressRepository->getAllAddresses($data['contact_id']));
            $object->setImages($this->contactImageRepository->findImagesByContactId($data['contact_id']));
        }

        return $object;
    }

    protected function propertyAvailable($needle, $haystack)
    {
        return array_key_exists($needle, $haystack) && !empty($haystack[$needle]);
    }

}