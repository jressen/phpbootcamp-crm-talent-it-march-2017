<?php

namespace Dashboard\Controller;


use Contact\Model\EmailAddressModelInterface;
use Contact\Model\ContactModelInterface;
use Contact\Model\CountryModelInterface;
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
     * @var CountryModelInterface
     */
    protected $countryModel;

    /**
     * @var FormInterface
     */
    protected $contactForm;

    /**
     * DashboardController constructor.
     * @param AuthenticationService $authService
     * @param ContactModelInterface $contactModel
     * @param EmailAddressModelInterface $contactEmailModel
     * @param CountryModelInterface $countryModel
     * @param FormInterface $contactForm
     */
    public function __construct(
        AuthenticationService $authService,
        ContactModelInterface $contactModel,
        EmailAddressModelInterface $contactEmailModel,
        CountryModelInterface $countryModel,
        FormInterface $contactForm
    )
    {
        $this->authService = $authService;
        $this->contactModel = $contactModel;
        $this->contactEmailModel = $contactEmailModel;
        $this->countryModel = $countryModel;
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

        $viewModel = new ViewModel([
            'contact' => $contact,
            'contactForm' => $this->contactForm,
            'countries' => $countries,
        ]);

        if (!$this->request->isPost()) {
            return $viewModel;
        }

        $data = $this->request->getPost();
        \Zend\Debug\Debug::dump($data);
        die;
    }
}