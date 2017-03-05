<?php

namespace Contact\Controller;


use Contact\Model\ContactModelInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ContactController extends AbstractActionController
{
    /**
     * @var ContactModelInterface
     */
    private $contactModel;

    /**
     * ContactController constructor.
     *
     * @param ContactModelInterface $contactModel
     */
    public function __construct(ContactModelInterface $contactModel)
    {
        $this->contactModel = $contactModel;
    }

    public function indexAction()
    {
        return $this->redirect()->toRoute('contact/overview', ['page' => 1]);
    }

    public function overviewAction()
    {
        $page = $this->params()->fromRoute('page', 1);
        $memberId = $this->identity()->getMemberId();

        $contacts = $this->contactModel->fetchAllContacts($memberId);

        return new ViewModel([
            'contacts' => $contacts,
            'page' => $page,
        ]);
    }
}