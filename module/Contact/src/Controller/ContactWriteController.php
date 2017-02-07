<?php

namespace Contact\Controller;


use Contact\Form\ContactForm;
use Contact\Model\Contact;
use Contact\Model\ContactCommandInterface;
use Contact\Model\ContactRepositoryInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ContactWriteController extends AbstractActionController
{
    /**
     * @var ContactCommandInterface
     */
    protected $command;

    /**
     * @var ContactRepositoryInterface
     */
    protected $repository;

    /**
     * @var ContactForm
     */
    protected $form;

    /**
     * ContactWriteController constructor.
     * @param ContactCommandInterface $command
     * @param ContactForm $form
     */
    public function __construct(
        ContactCommandInterface $command,
        ContactRepositoryInterface $repository,
        ContactForm $form
    )
    {
        $this->command = $command;
        $this->repository = $repository;
        $this->form = $form;
    }

    public function addAction()
    {
        $request = $this->getRequest();

        $viewModel = new ViewModel([
            'form' => $this->form,
        ]);

        if (!$request->isPost()) {
            return $viewModel;
        }

        $this->form->setData($request->getPost());

        if (!$this->form->isValid()) {
            return $viewModel;
        }

        $contact = $this->form->getData();

        try {
            $this->command->insertContact($contact);
        } catch (\Exception $exception) {
            // Need to add logging here
        }

        return $this->redirect()->toRoute('contact/detail', ['id' => $contact->getContactId()]);
    }

    public function editAction()
    {
        $id = $this->params()->fromRoute('id');
        if (!$id) {
            return $this->redirect()->toRoute('contact', ['action' => 'index']);
        }

        try {
            $contact = $this->repository->findContact($id);
        } catch (\InvalidArgumentException $exception) {
            return $this->redirect()->toRoute('contact', ['action' => 'index']);
        }

        $this->form->bind($contact);
        $viewModel = new ViewModel(['form' => $this->form]);
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return $viewModel;
        }

        $this->form->setData($request->getPost());

        if (!$this->form->isValid()) {
            return $viewModel;
        }

        $contact = $this->command->updateContact($this->form->getData());
        return $this->redirect()->toRoute('contact/detail', ['id' => $contact->getContactId()]);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('contact');
        }

        try {
            $contact = $this->repository->findContact($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('contact', ['action' => 'index']);
        }

        if ($this->getRequest()->isPost()) {
            $this->command->deleteContact($contact);
            return $this->redirect()->toRoute('contact', ['action' => 'index']);
        }

        return new ViewModel([
            'contact' => $contact,
        ]);
    }
}