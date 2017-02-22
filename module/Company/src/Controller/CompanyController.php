<?php

namespace Company\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CompanyController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel([
            'name' => sprintf('%s:%s()', __CLASS__, __FUNCTION__),
        ]);
    }
}