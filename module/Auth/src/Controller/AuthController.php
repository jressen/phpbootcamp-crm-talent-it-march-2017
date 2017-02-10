<?php

namespace Auth\Controller;


use Auth\Service\LinkedIn;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AuthController extends AbstractActionController
{
    /**
     * @var LinkedIn
     */
    protected $linkedInService;

    /**
     * AuthController constructor.
     * @param LinkedIn $linkedInService
     */
    public function __construct(LinkedIn $linkedInService)
    {
        $this->linkedInService = $linkedInService;
    }

    public function indexAction()
    {
        return new ViewModel([
            'linkedInUrl' => $this->linkedInService->getAuthenticationUrl(),
        ]);
    }

    public function callbackAction()
    {
        return new ViewModel();
    }
}