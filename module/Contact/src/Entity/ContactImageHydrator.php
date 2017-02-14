<?php

namespace Contact\Entity;


use Zend\Hydrator\HydratorInterface;

class ContactImageHydrator implements HydratorInterface
{
    /**
     * @inheritDoc
     */
    public function extract($object)
    {
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
        /** @var ContactImage $class */
        $class = get_class($object);
        return new $class(
            $data['contact_image_id'],
            $data['member_id'],
            $data['contact_id'],
            $data['image_link'],
            (bool) $data['image_active']
        );
    }

}