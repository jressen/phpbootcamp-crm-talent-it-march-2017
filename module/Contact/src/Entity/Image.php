<?php

namespace Contact\Entity;


class Image implements ImageInterface
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
     * Image constructor.
     * @param int $contactImageId
     * @param int $memberId
     * @param int $contactId
     * @param string $imageLink
     * @param bool $imageActive
     */
    public function __construct($contactImageId = 0, $memberId = 0, $contactId = 0, $imageLink = '', $imageActive = false)
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
     * @param int $contactImageId
     * @return Image
     */
    public function setContactImageId($contactImageId)
    {
        $this->contactImageId = $contactImageId;
        return $this;
    }

    /**
     * @return int
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * @param int $memberId
     * @return Image
     */
    public function setMemberId($memberId)
    {
        $this->memberId = $memberId;
        return $this;
    }

    /**
     * @return int
     */
    public function getContactId()
    {
        return $this->contactId;
    }

    /**
     * @param int $contactId
     * @return Image
     */
    public function setContactId($contactId)
    {
        $this->contactId = $contactId;
        return $this;
    }

    /**
     * @return string
     */
    public function getImageLink()
    {
        return $this->imageLink;
    }

    /**
     * @param string $imageLink
     * @return Image
     */
    public function setImageLink($imageLink)
    {
        $this->imageLink = $imageLink;
        return $this;
    }

    /**
     * @return bool
     */
    public function isImageActive()
    {
        return $this->imageActive;
    }

    /**
     * @param bool $imageActive
     * @return Image
     */
    public function setImageActive($imageActive)
    {
        $this->imageActive = $imageActive;
        return $this;
    }

}