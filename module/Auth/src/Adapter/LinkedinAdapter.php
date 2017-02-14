<?php

namespace Auth\Adapter;


use Auth\Entity\MemberInterface;
use Auth\Model\MemberModel;
use Zend\Authentication\Result;

class LinkedinAdapter implements LinkedinAdapterInterface
{
    /**
     * @var MemberInterface
     */
    protected $member;

    /**
     * @var MemberModel
     */
    protected $memberModel;

    /**
     * LinkedinAdapter constructor.
     *
     * @param MemberModel $memberModel
     */
    public function __construct(MemberModel $memberModel)
    {
        $this->memberModel = $memberModel;
    }

    /**
     * @return MemberInterface
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * @param MemberInterface $member
     * @return LinkedinAdapter
     */
    public function setMember($member)
    {
        $this->member = $member;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function authenticate()
    {
        $verifiedMember = $this->memberModel->getMember($this->member->getMemberId());
        if (0 === strcasecmp($verifiedMember->getLinkedinId(), $this->member->getLinkedinId())) {
            return new Result(Result::SUCCESS, $this->member);
        }
        return new Result(Result::FAILURE, $this->member, ['Cannot verify your identity']);
    }

}