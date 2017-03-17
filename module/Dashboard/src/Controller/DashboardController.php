<?php

namespace Dashboard\Controller;


use Contact\Entity\ContactInterface;
use Contact\Model\AddressModelInterface;
use Contact\Model\EmailAddressModelInterface;
use Contact\Model\ContactModelInterface;
use Contact\Model\CountryModelInterface;
use Contact\Service\ContactFormServiceInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DashboardController extends AbstractActionController
{
    /**
     * @var AuthenticationService
     */
    protected $authService;

    /**
     * @var ContactModelInterface
     */
    protected $contactModel;

    /**
     * @var EmailAddressModelInterface
     */
    protected $contactEmailModel;

    /**
     * @var AddressModelInterface
     */
    protected $contactAddressModel;

    /**
     * @var CountryModelInterface
     */
    protected $countryModel;

    /**
     * @var ContactFormServiceInterface
     */
    protected $contactFormService;

    /**
     * @var FormInterface
     */
    protected $contactForm;

    /**
     * DashboardController constructor.
     * @param AuthenticationService $authService
     * @param ContactModelInterface $contactModel
     * @param EmailAddressModelInterface $contactEmailModel
     * @param AddressModelInterface $addressModel
     * @param CountryModelInterface $countryModel
     * @param ContactFormServiceInterface $contactFormService
     * @param FormInterface $contactForm
     */
    public function __construct(
        AuthenticationService $authService,
        ContactModelInterface $contactModel,
        EmailAddressModelInterface $contactEmailModel,
        AddressModelInterface $addressModel,
        CountryModelInterface $countryModel,
        ContactFormServiceInterface $contactFormService,
        FormInterface $contactForm
    )
    {
        $this->authService = $authService;
        $this->contactModel = $contactModel;
        $this->contactEmailModel = $contactEmailModel;
        $this->contactAddressModel = $addressModel;
        $this->countryModel = $countryModel;
        $this->contactFormService = $contactFormService;
        $this->contactForm = $contactForm;
    }

    public function overviewAction()
    {
        if (!$this->authService->hasIdentity()) {
            return $this->redirect()->toRoute('auth');
        }
        $member = $this->authService->getIdentity();

        return new ViewModel([]);
    }

    public function companiesAction() {
        if (!$this->authService->hasIdentity()) {
            return $this->redirect()->toRoute('auth');
        }
        $member = $this->authService->getIdentity();

        return new ViewModel([
            'companies'
        ]);
    }

    public function contactsAction()
    {
        if (!$this->authService->hasIdentity()) {
            return $this->redirect()->toRoute('auth');
        }
        $member = $this->authService->getIdentity();

        $contactCollection = $this->contactModel->fetchAllContacts($member->getMemberId());

        return new ViewModel([
            'contacts' => $contactCollection,
        ]);
    }

    public function contactsDetailAction()
    {
        if (!$this->authService->hasIdentity()) {
            return $this->redirect()->toRoute('auth');
        }

        $contactId = $this->params()->fromRoute('contactId', 0);
        $memberId = $this->authService->getIdentity()->getMemberId();

        $contact = $this->contactModel->findContact($memberId, $contactId);

        return new ViewModel([
            'contact' => $contact,
        ]);
    }

    public function contactsEditAction()
    {
        if (!$this->authService->hasIdentity()) {
            return $this->redirect()->toRoute('auth');
        }

        $contactId = $this->params()->fromRoute('contactId', 0);
        $memberId = $this->authService->getIdentity()->getMemberId();

        $contact = $this->contactModel->findContact($memberId, $contactId);
        $countries = $this->countryModel->fetchAllCountries();

        $this->contactForm->bind($contact);

        $viewModel = new ViewModel([
            'contactForm' => $this->contactForm,
            'contact' => $contact,
            'countries' => $countries,
        ]);

        if (!$this->request->isPost()) {
            return $viewModel;
        }

        $data = $this->request->getPost();
        $this->contactForm->setData($data);
        if (!$this->contactForm->isValid()) {
            return $viewModel;
        }

        $validData = $this->contactForm->getData();
        if (!$validData instanceof ContactInterface) {
            return $viewModel;
        }
        $this->contactModel->saveContact($memberId, $validData);
        foreach ($validData->getEmailAddresses() as $emailAddress) {
            $this->contactEmailModel->saveEmailAddress($contactId, $emailAddress);
        }
        foreach ($validData->getAddresses() as $address) {
            $this->contactAddressModel->saveAddress($contactId, $address);
        }
        
        return $this->redirect()->toRoute('dashboard/contacts/detail', ['contactId' => $contactId]);
    }
}