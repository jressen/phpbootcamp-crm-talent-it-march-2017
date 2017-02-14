<?php

namespace Auth\Controller;

use Auth\Service\LinkedIn;
use Auth\Service\MemberService;
use Contact\Model\ContactCommandInterface;
use Contact\Model\ContactEmailCommandInterface;
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
     * @var MemberService
     */
    protected $memberService;

    /**
     * AuthController constructor.
     *
     * @param Container $sessionContainer
     * @param LinkedIn $linkedInService
     * @param MemberService $memberService
     */
    public function __construct(
        Container $sessionContainer,
        LinkedIn $linkedInService,
        MemberService $memberService
    )
    {
        $this->sessionContainer = $sessionContainer;
        $this->linkedInService = $linkedInService;
        $this->memberService = $memberService;
    }

    public function indexAction()
    {
        if (isset ($this->sessionContainer->accessCode)) {
            return $this->redirect()->toRoute('auth/welcome');
        }
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

        try {
            $accessCode = $this->linkedInService->requestAccessCode($response->code);
        } catch (\RuntimeException $runtimeException) {
            return $this->redirect()->toRoute('auth/problem');
        }

        $this->sessionContainer->accessCode = $accessCode;
        return $this->redirect()->toRoute('auth/welcome');
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

    public function welcomeAction()
    {
        $accessToken = $this->sessionContainer->accessCode['access_token'];

        if (!isset ($this->sessionContainer->member)) {
            $options = [];
            try {
                $additionalProfile = $this->linkedInService->getAdditionalProfileDetails($accessToken, $options);
                $member = $this->memberService->registerNewMember($additionalProfile, $accessToken);
            } catch (\RuntimeException $runtimeException) {
            }
            $this->sessionContainer->member = $member;
        }

        \Zend\Debug\Debug::dump([
            $this->sessionContainer->member
        ]);
        return new ViewModel();
    }
}