<?php

namespace Dashboard\Controller;


use Contact\Model\ContactEmailRepositoryInterface;
use Contact\Model\ContactRepositoryInterface;
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
     * @var ContactRepositoryInterface
     */
    protected $contactModel;

    /**
     * @var ContactEmailRepositoryInterface
     */
    protected $contactEmailModel;

    /**
     * @var FormInterface
     */
    protected $contactForm;

    /**
     * DashboardController constructor.
     * @param AuthenticationService $authService
     * @param ContactRepositoryInterface $contactModel
     * @param ContactEmailRepositoryInterface $contactEmailModel
     * @param FormInterface $contactForm
     */
    public function __construct(
        AuthenticationService $authService,
        ContactRepositoryInterface $contactModel,
        ContactEmailRepositoryInterface $contactEmailModel,
        FormInterface $contactForm
    )
    {
        $this->authService = $authService;
        $this->contactModel = $contactModel;
        $this->contactEmailModel = $contactEmailModel;
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

        $contactCollection = $this->contactModel->findAllContacts($member->getMemberId());

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

        return new ViewModel([
            'contact' => $contact,
            'contactForm' => $this->contactForm,
        ]);
    }
}