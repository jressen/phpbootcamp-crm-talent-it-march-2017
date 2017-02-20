<?php

namespace Auth\Service;


use Auth\Entity\MemberInterface;
use Auth\Model\MemberModel;
use Contact\Entity\ContactAddressInterface;
use Contact\Entity\ContactEmailInterface;
use Contact\Entity\ContactImageInterface;
use Contact\Entity\ContactInterface;
use Contact\Model\ContactAddressCommandInterface;
use Contact\Model\ContactCommandInterface;
use Contact\Model\ContactEmailCommandInterface;
use Contact\Model\ContactImageModelInterface;

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
     * @var ContactAddressCommandInterface
     */
    protected $contactAddressCommand;

    /**
     * @var ContactAddressInterface
     */
    protected $contactAddressPrototype;

    /**
     * @var ContactImageModelInterface
     */
    protected $contactImageModel;

    /**
     * @var ContactImageInterface
     */
    protected $contactImagePrototype;

    /**
     * MemberService constructor.
     *
     * @param MemberModel $memberModel
     * @param MemberInterface $memberPrototype
     * @param ContactCommandInterface $contactCommand
     * @param ContactInterface $contactPrototype
     * @param ContactEmailCommandInterface $contactEmailCommand
     * @param ContactEmailInterface $contactEmailPrototype
     * @param ContactAddressCommandInterface $contactAddressCommand
     * @param ContactAddressInterface $contactAddress
     * @param ContactImageModelInterface $contactImageModel
     * @param ContactImageInterface $contactImage
     */
    public function __construct(
        MemberModel $memberModel,
        MemberInterface $memberPrototype,
        ContactCommandInterface $contactCommand,
        ContactInterface $contactPrototype,
        ContactEmailCommandInterface $contactEmailCommand,
        ContactEmailInterface $contactEmailPrototype,
        ContactAddressCommandInterface $contactAddressCommand,
        ContactAddressInterface $contactAddress,
        ContactImageModelInterface $contactImageModel,
        ContactImageInterface $contactImage
    )
    {
        $this->memberModel = $memberModel;
        $this->memberPrototype = $memberPrototype;
        $this->contactCommand = $contactCommand;
        $this->contactPrototype = $contactPrototype;
        $this->contactEmailCommand = $contactEmailCommand;
        $this->contactEmailPrototype = $contactEmailPrototype;
        $this->contactAddressCommand = $contactAddressCommand;
        $this->contactAddressPrototype = $contactAddress;
        $this->contactImageModel = $contactImageModel;
        $this->contactImagePrototype = $contactImage;
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

        $contactAddressClass = get_class($this->contactAddressPrototype);
        $newContactAddress = new $contactAddressClass(
            0,
            $memberEntity->getMemberId(),
            $contactEntity->getContactId(),
            '', // street1
            '', // street2
            '', // postcode
            '', // city
            '', // province
            (isset ($memberProfileData['location']['country']['code']) ?
                strtoupper($memberProfileData['location']['country']['code']) :
                '')
        );
        $contactAddressEntity = $this->contactAddressCommand->saveContactAddress($newContactAddress);

        $contactImageClass = get_class($this->contactImagePrototype);
        $newContactImage = new $contactImageClass(
            0,
            $memberEntity->getMemberId(),
            $contactEntity->getContactId(),
            $memberProfileData['pictureUrl'],
            true
        );
        $contactImageEntity = $this->contactImageModel->saveContactImage($newContactImage);

        return $memberEntity;
    }

    /**
     * Update an existing member
     *
     * @param array $memberProfileData
     * @param string $accessToken
     * @return MemberInterface
     */
    public function updateMember(array $memberProfileData, $accessToken)
    {
        $member = $this->memberModel->getMemberByLinkedinId($memberProfileData['id']);
        $memberClass = get_class($this->memberPrototype);
        $memberEntity = new $memberClass(
            $member->getMemberId(),
            $member->getLinkedinId(),
            $accessToken
        );
        $this->memberModel->saveMember($memberEntity);
        return $memberEntity;
    }

}