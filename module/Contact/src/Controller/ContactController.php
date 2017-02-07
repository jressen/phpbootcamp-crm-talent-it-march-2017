<?php

namespace Contact\Controller;


use Contact\Form\ContactForm;
use Contact\Model\Contact;
use Contact\Model\ContactRepositoryInterface;
use Contact\Model\ContactTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ContactController extends AbstractActionController
{
    /**
     * @var ContactRepositoryInterface
     */
    protected $contactRepository;

    /**
     * ContactController constructor.
     *
     * @param ContactRepositoryInterface $contactRepository
     */
    public function __construct(
        ContactRepositoryInterface $contactRepository
    )
    {
        $this->contactRepository = $contactRepository;
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

        return new ViewModel([
            'contact' => $contact,
        ]);
    }
}