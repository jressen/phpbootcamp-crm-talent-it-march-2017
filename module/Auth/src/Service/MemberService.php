<?php

namespace Auth\Service;


use Auth\Entity\MemberInterface;
use Auth\Model\MemberModel;
use Contact\Entity\ContactEmailInterface;
use Contact\Entity\ContactInterface;
use Contact\Model\ContactCommandInterface;
use Contact\Model\ContactEmailCommandInterface;

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
     * @var ContactCommandInterface
     */
    protected $contactCommand;

    /**
     * @var ContactInterface
     */
    protected $contactPrototype;

    /**
     * @var ContactEmailCommandInterface
     */
    protected $contactEmailCommand;

    /**
     * @var ContactEmailInterface
     */
    protected $contactEmailPrototype;

    /**
     * MemberService constructor.
     *
     * @param MemberModel $memberModel
     * @param MemberInterface $memberPrototype
     * @param ContactCommandInterface $contactCommand
     * @param ContactInterface $contactPrototype
     * @param ContactEmailCommandInterface $contactEmailCommand
     * @param ContactEmailInterface $contactEmailPrototype
     */
    public function __construct(
        MemberModel $memberModel,
        MemberInterface $memberPrototype,
        ContactCommandInterface $contactCommand,
        ContactInterface $contactPrototype,
        ContactEmailCommandInterface $contactEmailCommand,
        ContactEmailInterface $contactEmailPrototype
    )
    {
        $this->memberModel = $memberModel;
        $this->memberPrototype = $memberPrototype;
        $this->contactCommand = $contactCommand;
        $this->contactPrototype = $contactPrototype;
        $this->contactEmailCommand = $contactEmailCommand;
        $this->contactEmailPrototype = $contactEmailPrototype;
    }


    /**
     * Register a new member based on the information retrieved from LinkedIn
     *
     * @param array $memberProfileData
     * @param string $accessToken
     * @return MemberInterface
     */
    public function registerNewMember(array $memberProfileData, $accessToken)
    {
        $memberClass = get_class($this->memberPrototype);
        $newMember = new $memberClass(0, $memberProfileData['id'], $accessToken);
        $memberEntity = $this->memberModel->saveMember($newMember);

        $contactClass = get_class($this->contactPrototype);
        $newContact = new $contactClass(
            0,
            $memberEntity->getMemberId(),
            $memberProfileData['firstName'],
            $memberProfileData['lastName']
        );
        $contactEntity = $this->contactCommand->insertContact($newContact);

        $contactEmailClass = get_class($this->contactEmailPrototype);
        $newContactEmail = new $contactEmailClass(
            0,
            $memberEntity->getMemberId(),
            $contactEntity->getContactId(),
            $memberProfileData['emailAddress'],
            true
        );
        $contactEmailEntity = $this->contactEmailCommand->insertContactEmail($newContactEmail);
        return $memberEntity;
    }

}