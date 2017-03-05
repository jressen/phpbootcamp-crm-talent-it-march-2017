<?php

namespace Contact\Entity;


use Contact\Model\ImageModelInterface;
use Zend\Hydrator\HydratorInterface;

class ContactImageHydrator implements HydratorInterface
{
    /**
     * @var ImageModelInterface
     */
    protected $imageModel;

    /**
     * ContactImageHydrator constructor.
     * @param ImageModelInterface $imageModel
     */
    public function __construct(ImageModelInterface $imageModel)
    {
        $this->imageModel = $imageModel;
    }

    /**
     * @inheritDoc
     */
    public function extract($object)
    {
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
            $object->setImages(
                $this->imageModel->fetchAllImages($data['contact_id'])
            );
        }

        return $object;
    }

    private function propertyAvailable($property, $data)
    {
        return (array_key_exists($property, $data) && !empty($data[$property]));
    }
}