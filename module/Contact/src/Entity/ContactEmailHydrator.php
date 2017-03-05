<?php

namespace Contact\Entity;


use Contact\Model\EmailAddressModelInterface;
use Zend\Hydrator\HydratorInterface;

class ContactEmailHydrator implements HydratorInterface
{
    /**
     * @var EmailAddressModelInterface
     */
    protected $emailAddressModel;

    /**
     * ContactEmailHydrator constructor.
     *
     * @param EmailAddressModelInterface $emailAddressModel
     */
    public function __construct(EmailAddressModelInterface $emailAddressModel)
    {
        $this->emailAddressModel = $emailAddressModel;
    }

    /**
     * @inheritDoc
     */
    public function extract($object)
    {
        if (!$object instanceof ContactInterface) {
            return [];
        }
        return [];
    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof ContactInterface) {
            return $object;
        }

        if ($this->propertyAvailable('contact_id', $data)) {
            $object->setEmailAddresses(
                $this->emailAddressModel->fetchAllEmailAddresses($data['contact_id'])
            );
        }

        return $object;
    }

    private function propertyAvailable($property, $data)
    {
        return (array_key_exists($property, $data) && !empty($data[$property]));
    }
}