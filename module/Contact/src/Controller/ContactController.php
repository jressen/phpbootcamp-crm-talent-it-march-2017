<?php

namespace Contact\Controller;


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
}