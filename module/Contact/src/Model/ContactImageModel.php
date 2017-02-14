<?php

namespace Contact\Model;


use Contact\Entity\ContactImageInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;

class ContactImageModel implements ContactImageModelInterface
{
    /**
     * @var AdapterInterface
     */
    protected $db;
    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @var ContactImageInterface
     */
    protected $contactImagePrototype;

    /**
     * ContactImageModel constructor.
     * @param AdapterInterface $db
     * @param HydratorInterface $hydrator
     * @param ContactImageInterface $contactImagePrototype
     */
    public function __construct(
        AdapterInterface $db,
        HydratorInterface $hydrator,
        ContactImageInterface $contactImagePrototype
    )
    {
        $this->db = $db;
        $this->hydrator = $hydrator;
        $this->contactImagePrototype = $contactImagePrototype;
    }

    /**
     * @inheritdoc
     */
    public function saveContactImage(ContactImageInterface $contactImage)
    {
        if (0 < (int) $contactImage->getContactImageId()) {
            return $this->updateContactImage($contactImage);
        }
        return $this->insertContactImage($contactImage);
    }

    /**
     * Store a new instance of ContactImage
     *
     * @param ContactImageInterface $contactImage
     * @return ContactImageInterface
     */
    private function insertContactImage(ContactImageInterface $contactImage)
    {
        $date = new \DateTime();
        $contactImageData = $this->hydrator->extract($contactImage);
        $contactImageData['modified'] = $date->format('Y-m-d H:i:s');
        $contactImageData['created'] = $date->format('Y-m-d H:i:s');
        unset ($contactImageData['contact_image_id']);

        $insert = new Insert('contact_image');
        $insert->values($contactImageData);

        $sql = new Sql($this->db);
        $stmt = $sql->prepareStatementForSqlObject($insert);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException('Database error occurred during storage of contact image');
        }

        $id = (int) $result->getGeneratedValue();
        $newContactImageClass = get_class($this->contactImagePrototype);

        return new $newContactImageClass(
            $id,
            $contactImage->getMemberId(),
            $contactImage->getContactId(),
            $contactImage->getImageLink(),
            $contactImage->isImageActive()
        );
    }

    /**
     * Updates an existing instance of ContactImage
     *
     * @param ContactImageInterface $contactImage
     * @return ContactImageInterface
     */
    private function updateContactImage(ContactImageInterface $contactImage)
    {
        $date = new \DateTime();
        $contactImageData = $this->hydrator->extract($contactImage);
        $contactImageData['modified'] = $date->format('Y-m-d H:i:s');
        unset ($contactImageData['contact_image_id']);

        $update = new Update('contact_image');
        $update->set($contactImageData)
            ->where([
                'contact_image_id = ?' => $contactImage->getContactImageId(),
                'member_id = ?' => $contactImage->getMemberId(),
                'contact_id = ?' => $contactImage->getContactId(),
            ]);

        $sql = new Sql($this->db);
        $stmt = $sql->prepareStatementForSqlObject($update);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException('Database error occurred during storage of contact image');
        }

        return $contactImage;
    }
}