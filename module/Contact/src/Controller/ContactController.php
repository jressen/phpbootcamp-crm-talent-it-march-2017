<?php

namespace Contact\Controller;


use Contact\Form\ContactForm;
use Contact\Model\Contact;
use Contact\Model\ContactTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ContactController extends AbstractActionController
{
    /**
     * @var ContactTable
     */
    protected $contactTable;

    /**
     * ContactController constructor.
     * @param ContactTable $contactTable
     */
    public function __construct(ContactTable $contactTable)
    {
        $this->contactTable = $contactTable;
    }

    public function indexAction()
    {
        return new ViewModel([
            'contacts' => $this->contactTable->fetchAll(),
        ]);
    }

    public function addAction()
    {
        $form = new ContactForm('contact');
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $contact = new Contact();
        $form->setInputFilter($contact->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $contact->exchangeArray($form->getData());
        $this->contactTable->saveContact($contact);
        return $this->redirect()->toRoute('contact');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('contact', ['action' => 'add']);
        }

        // Retrieve the contact with the specified id. Doing so raises
        // an exception if the contact is not found, which should result
        // in redirecting to the landing page.
        try {
            $contact = $this->contactTable->getContact($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('contact', ['action' => 'index']);
        }

        $form = new ContactForm();
        $form->bind($contact);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['contactId' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($contact->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->contactTable->saveContact($contact);

        // Redirect to album list
        return $this->redirect()->toRoute('contact', ['action' => 'index']);
    }
}