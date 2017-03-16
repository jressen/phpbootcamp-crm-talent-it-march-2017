<?php

namespace Auth\Service;


use Auth\Entity\MemberInterface;
use Auth\Model\MemberModel;
use Contact\Entity\AddressInterface;
use Contact\Entity\CountryInterface;
use Contact\Entity\EmailAddressInterface;
use Contact\Entity\ImageInterface;
use Contact\Entity\ContactInterface;
use Contact\Model\AddressModelInterface;
use Contact\Model\ContactModelInterface;
use Contact\Model\CountryModelInterface;
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
     * @var CountryModelInterface
     */
    protected $countryModel;

    /**
     * @var CountryInterface
     */
    protected $countryPrototype;

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
     * @param CountryModelInterface $countryModel
     * @param CountryInterface $country
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
        ImageInterface $contactImage,
        CountryModelInterface $countryModel,
        CountryInterface $country
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
        $this->countryModel = $countryModel;
        $this->countryPrototype = $country;
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
        $contactId = $contactEntity->getContactId();

        $newContactEmail = clone $this->contactEmailPrototype;
        $newContactEmail->setMemberId($memberId)
            ->setContactId($contactId)
            ->setEmailAddress($memberProfileData['emailAddress'])
            ->setPrimary(true);
        $contactEmailEntity = $this->contactEmailCommand->saveEmailAddress($newContactEmail);

        $countryCode = (
            isset ($memberProfileData['location']['country']['code'])
                ? strtoupper($memberProfileData['location']['country']['code'])
                : ''
        );

        $country = $this->countryModel->findCountryByIso($countryCode);

        $newContactAddress = clone $this->contactAddressPrototype;
        $newContactAddress->setMemberId($memberId)
            ->setContactId($contactId)
            ->setCountry($country);

        $contactAddressEntity = $this->contactAddressCommand->saveAddress($newContactAddress);

        $contactImageClass = get_class($this->contactImagePrototype);
        $newContactImage = clone $this->contactImagePrototype;
        $newContactImage->setMemberId($memberId)
            ->setContactId($contactId)
            ->setImageLink($memberProfileData['pictureUrl'])
            ->setImageActive(true);
        $contactImageEntity = $this->contactImageModel->saveImage($newContactImage);

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