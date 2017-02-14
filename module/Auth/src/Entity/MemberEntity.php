<?php

namespace Auth\Entity;


class MemberEntity implements MemberInterface
{
    /**
     * @var int
     */
    protected $memberId;

    /**
     * @var string
     */
    protected $linkedinId;

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * MemberEntity constructor.
     *
     * @param int $memberId
     * @param string $linkedinId
     * @param string $accessToken
     */
    public function __construct($memberId, $linkedinId, $accessToken)
    {
        $this->memberId = $memberId;
        $this->linkedinId = $linkedinId;
        $this->accessToken = $accessToken;
    }

    /**
     * @inheritDoc
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * @inheritDoc
     */
    public function getLinkedinId()
    {
        return $this->linkedinId;
    }

    /**
     * @inheritDoc
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

}