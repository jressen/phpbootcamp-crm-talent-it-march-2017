<?php

namespace Contact\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ContactController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel(['name' => 'ContactController::indexAction']);
    }
}