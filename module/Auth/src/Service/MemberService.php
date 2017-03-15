<?php

namespace Auth\Service;


use Auth\Entity\MemberInterface;
use Auth\Model\MemberModel;
use Contact\Entity\AddressInterface;
use Contact\Entity\EmailAddressInterface;
use Contact\Entity\ImageInterface;
use Contact\Entity\ContactInterface;
use Contact\Model\AddressModelInterface;
use Contact\Model\ContactModelInterface;
use Contact\Model\EmailAddressModelInterface;
use Contact\Model\ImageModelInterface;

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
     * @var ContactModelInterface
     */
    protected $contactCommand;

    /**
     * @var ContactInterface
     */
    protected $contactPrototype;

    /**
     * @var EmailAddressModelInterface
     */
    protected $contactEmailCommand;

    /**
     * @var EmailAddressInterface
     */
    protected $contactEmailPrototype;

    /**
     * @var AddressModelInterface
     */
    protected $contactAddressCommand;

    /**
     * @var AddressInterface
     */
    protected $contactAddressPrototype;

    /**
     * @var ImageModelInterface
     */
    protected $contactImageModel;

    /**
     * @var ImageInterface
     */
    protected $contactImagePrototype;

    /**
     * MemberService constructor.
     *
     * @param MemberModel $memberModel
     * @param MemberInterface $memberPrototype
     * @param ContactModelInterface $contactCommand
     * @param ContactInterface $contactPrototype
     * @param EmailAddressModelInterface $contactEmailCommand
     * @param EmailAddressInterface $contactEmailPrototype
     * @param AddressModelInterface $contactAddressCommand
     * @param AddressInterface $contactAddress
     * @param ImageModelInterface $contactImageModel
     * @param ImageInterface $contactImage
     */
    public function __construct(
        MemberModel $memberModel,
        MemberInterface $memberPrototype,
        ContactModelInterface $contactCommand,
        ContactInterface $contactPrototype,
        EmailAddressModelInterface $contactEmailCommand,
        EmailAddressInterface $contactEmailPrototype,
        AddressModelInterface $contactAddressCommand,
        AddressInterface $contactAddress,
        ImageModelInterface $contactImageModel,
        ImageInterface $contactImage
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

        $memberId = $memberEntity->getMemberId();

        $newContact = clone $this->contactPrototype;
        $newContact->setMemberId($memberId)
            ->setFirstName($memberProfileData['firstName'])
            ->setLastName($memberProfileData['lastName']);

        $contactEntity = $this->contactCommand->saveContact($memberId, $newContact);
        \Zend\Debug\Debug::dump($contactEntity, __FUNCTION__ . ' -> $contactEntity');

        $newContactEmail = clone $this->contactEmailPrototype;
        $newContactEmail->setMemberId($memberId)
            ->setContactId($contactEntity->getContactId())
            ->setEmailAddress($memberProfileData['emailAddress'])
            ->setPrimary(true);
        $contactEmailEntity = $this->contactEmailCommand->saveEmailAddress($newContactEmail);

        \Zend\Debug\Debug::dump($contactEmailEntity, __FUNCTION__ . ' -> $contactEmailEntity');

        /*$contactAddressClass = get_class($this->contactAddressPrototype);
        $newContactAddress = new $contactAddressClass(
            0,
            $memberId,
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
        $contactAddressEntity = $this->contactAddressCommand->saveAddress($contactEntity->getContactId(), $newContactAddress);
        \Zend\Debug\Debug::dump($contactAddressEntity, __FUNCTION__ . ' -> $contactAddressEntity');

        $contactImageClass = get_class($this->contactImagePrototype);
        $newContactImage = new $contactImageClass(
            0,
            $memberId,
            $contactEntity->getContactId(),
            $memberProfileData['pictureUrl'],
            true
        );
        $contactImageEntity = $this->contactImageModel->saveImage($newContactImage);

        \Zend\Debug\Debug::dump($contactImageEntity, __FUNCTION__ . ' -> $contactImageEntity');
        die;*/

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

    /**
     * See if the member is already registered in our data storage
     *
     * @param array $memberProfileData
     * @return bool
     */
    public function isRegistered(array $memberProfileData)
    {
        try {
            $member = $this->memberModel->getMemberByLinkedinId($memberProfileData['id']);
            return true;
        } catch (\InvalidArgumentException $invalidArgumentException) {
            return false;
        }
    }

}