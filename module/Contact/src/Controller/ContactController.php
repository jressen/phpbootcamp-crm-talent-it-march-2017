<?php

namespace Contact\Controller;


use Contact\Form\ContactForm;
use Contact\Model\Contact;
use Contact\Model\ContactAddressRepositoryInterface;
use Contact\Model\ContactEmailRepositoryInterface;
use Contact\Model\ContactRepositoryInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ContactController extends AbstractActionController
{
    /**
     * @var ContactRepositoryInterface
     */
    protected $contactRepository;

    /**
     * @var ContactEmailRepositoryInterface
     */
    protected $contactEmailRespository;

    /**
     * @var ContactAddressRepositoryInterface
     */
    protected $contactAddressRepository;

    /**
     * ContactController constructor.
     *
     * @param ContactRepositoryInterface $contactRepository
     * @param ContactEmailRepositoryInterface $contactEmailRepository
     * @param ContactAddressRepositoryInterface $contactAddressRepository
     */
    public function __construct(
        ContactRepositoryInterface $contactRepository,
        ContactEmailRepositoryInterface $contactEmailRepository,
        ContactAddressRepositoryInterface $contactAddressRepository
    )
    {
        $this->contactRepository = $contactRepository;
        $this->contactEmailRespository = $contactEmailRepository;
        $this->contactAddressRepository = $contactAddressRepository;
    }

    public function indexAction()
    {
        return new ViewModel([
            'contacts' => $this->contactRepository->findAllContacts(),
        ]);
    }

    public function detailAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('contact', ['action' => 'add']);
        }

        try {
            $contact = $this->contactRepository->findContact($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('contact', ['action' => 'index']);
        }

        $contactEmailList = [];
        try {
            $contactEmailList = $this->contactEmailRespository->findAllContactEmails($id);
        } catch (\Exception $exception) {
            // No email accounts linked to this contact
        }

        $contactAddressList = [];
        try {
            $contactAddressList = $this->contactAddressRepository->getAllAddresses($id);
        } catch (\Exception $exception) {
            // No address details linked to this contact
        }

        return new ViewModel([
            'contact' => $contact,
            'contactEmails' => $contactEmailList,
            'contactAddresses' => $contactAddressList,
        ]);
    }
}