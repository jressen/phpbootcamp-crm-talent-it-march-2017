<?php

namespace Auth\Controller;


use Auth\Service\LinkedIn;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class AuthController extends AbstractActionController
{
    /**
     * @var Container
     */
    protected $sessionContainer;

    /**
     * @var LinkedIn
     */
    protected $linkedInService;

    /**
     * AuthController constructor.
     *
     * @param Container $sessionContainer
     * @param LinkedIn $linkedInService
     */
    public function __construct(Container $sessionContainer, LinkedIn $linkedInService)
    {
        $this->sessionContainer = $sessionContainer;
        $this->linkedInService = $linkedInService;
    }

    public function indexAction()
    {
        $csrf = md5('foo-bar' . date('Y-m-d H:i:s'));
        $this->sessionContainer->csrf = $csrf;
        return new ViewModel([
            'linkedInUrl' => $this->linkedInService->getAuthenticationUrl($csrf),
        ]);
    }

    public function callbackAction()
    {
        $response = $this->getRequest()->getQuery();
        if (0 !== strcasecmp($this->sessionContainer->csrf, $response->state)) {
            return $this->redirect()->toRoute('auth/problem');
        }
        if (isset ($response->error)) {
            if ('user_cancelled_authorize' === $response->error) {
                return $this->redirect()->toRoute('auth/cancelled');
            }
            if ('user_cancelled_login' === $response->error) {
                return $this->redirect()->toRoute('auth/cancelled');
            }
        }
        $this->linkedInService->requestAccessCode($response->code);
        return new ViewModel();
    }

    public function problemAction()
    {
        $this->getResponse()->setStatusCode(401);
        return new ViewModel();
    }

    public function cancelledAction()
    {
        $this->getResponse()->setStatusCode(403);
        return new ViewModel();
    }
}