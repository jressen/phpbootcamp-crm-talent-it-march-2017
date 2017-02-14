<?php

namespace Auth\Service;


use Auth\Entity\MemberInterface;
use Auth\Model\MemberModel;

class MemberService
{
    /**
     * @var MemberModel
     */
    protected $memberModel;

    /**
     * @var MemberInterface
     */
    protected $memberPrototype;

    /**
     * MemberService constructor.
     * @param MemberModel $memberModel
     * @param MemberInterface $memberPrototype
     */
    public function __construct(MemberModel $memberModel, MemberInterface $memberPrototype)
    {
        $this->memberModel = $memberModel;
        $this->memberPrototype = $memberPrototype;
    }

    /**
     * Register a new member based on the information retrieved from LinkedIn
     *
     * @param array $memberProfileData
     * @param string $accessToken
     */
    public function registerNewMember(array $memberProfileData, $accessToken)
    {
        $memberEntity = get_class($this->memberPrototype);
        $newMember = new $memberEntity(0, $memberProfileData['id'], $accessToken);
        $this->memberModel->saveMember($newMember);
    }

}