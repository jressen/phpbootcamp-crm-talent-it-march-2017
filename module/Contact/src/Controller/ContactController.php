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
}