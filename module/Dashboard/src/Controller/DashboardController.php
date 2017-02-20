<?php

namespace Dashboard\Controller;


use Contact\Model\ContactEmailRepositoryInterface;
use Contact\Model\ContactRepositoryInterface;
use Zend\Authentication\AuthenticationService;
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
     * DashboardController constructor.
     * @param AuthenticationService $authService
     * @param ContactRepositoryInterface $contactModel
     * @param ContactEmailRepositoryInterface $contactEmailModel
     */
    public function __construct(
        AuthenticationService $authService,
        ContactRepositoryInterface $contactModel,
        ContactEmailRepositoryInterface $contactEmailModel
    )
    {
        $this->authService = $authService;
        $this->contactModel = $contactModel;
        $this->contactEmailModel = $contactEmailModel;
    }

    public function overviewAction()
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
}