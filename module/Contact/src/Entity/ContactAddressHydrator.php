<?php

namespace Contact\Entity;


use Contact\Model\AddressModelInterface;
use Zend\Hydrator\HydratorInterface;

class ContactAddressHydrator implements HydratorInterface
{
    /**
     * @var AddressModelInterface
     */
    protected $addressModel;

    /**
     * ContactAddressHydrator constructor.
     *
     * @param AddressModelInterface $addressModel
     */
    public function __construct(AddressModelInterface $addressModel)
    {
        $this->addressModel = $addressModel;
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
            $object->setAddresses(
                $this->addressModel->fetchAllAddresses($data['contact_id'])
            );
        }

        return $object;
    }

    private function propertyAvailable($property, $data)
    {
        return (array_key_exists($property, $data) && !empty($data[$property]));
    }

}