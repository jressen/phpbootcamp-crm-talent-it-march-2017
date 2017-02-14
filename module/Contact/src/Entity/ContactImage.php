<?php

namespace Contact\Entity;


class ContactImage implements ContactImageInterface
{
    /**
     * @var int
     */
    protected $contactImageId;

    /**
     * @var int
     */
    protected $memberId;

    /**
     * @var int
     */
    protected $contactId;

    /**
     * @var string
     */
    protected $imageLink;

    /**
     * @var bool
     */
    protected $imageActive;

    /**
     * ContactImage constructor.
     *
     * @param int $contactImageId
     * @param int $memberId
     * @param int $contactId
     * @param string $imageLink
     * @param bool $imageActive
     */
    public function __construct(
        $contactImageId,
        $memberId,
        $contactId,
        $imageLink,
        $imageActive = false
    )
    {
        $this->contactImageId = $contactImageId;
        $this->memberId = $memberId;
        $this->contactId = $contactId;
        $this->imageLink = $imageLink;
        $this->imageActive = $imageActive;
    }

    /**
     * @return int
     */
    public function getContactImageId()
    {
        return $this->contactImageId;
    }

    /**
     * @return int
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * @return int
     */
    public function getContactId()
    {
        return $this->contactId;
    }

    /**
     * @return string
     */
    public function getImageLink()
    {
        return $this->imageLink;
    }

    /**
     * @return bool
     */
    public function isImageActive()
    {
        return $this->imageActive;
    }
}