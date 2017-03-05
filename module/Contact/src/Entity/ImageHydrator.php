<?php

namespace Contact\Entity;


use Zend\Hydrator\HydratorInterface;

class ImageHydrator implements HydratorInterface
{
    /**
     * @inheritDoc
     */
    public function extract($object)
    {
        if (!$object instanceof ImageInterface) {
            return [];
        }

        return [
            'contact_image_id' => $object->getContactImageId(),
            'member_id' => $object->getMemberId(),
            'contact_id' => $object->getContactId(),
            'image_link' => $object->getImageLink(),
            'image_active' => $object->isImageActive() ? 1 : 0,
        ];
    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof ImageInterface) {
            return $object;
        }

        if ($this->propertyAvailable('contact_image_id', $data)) {
            $object->setContactImageId($data['contact_image_id']);
        }

        if ($this->propertyAvailable('member_id', $data)) {
            $object->setMemberId($data['member_id']);
        }

        if ($this->propertyAvailable('contact_id', $data)) {
            $object->setContactId($data['contact_id']);
        }

        if ($this->propertyAvailable('image_link', $data)) {
            $object->setImageLink($data['image_link']);
        }

        if ($this->propertyAvailable('image_active', $data)) {
            $object->setImageActive((1 === (int) $data['image_active']));
        }

        return $object;
    }

    private function propertyAvailable($property, $data)
    {
        return (array_key_exists($property, $data) && !empty($data[$property]));
    }
}