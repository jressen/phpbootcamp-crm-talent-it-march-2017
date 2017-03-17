<?php

namespace Auth\Controller;

use Auth\Service\LinkedIn;
use Auth\Service\MemberService;
use Contact\Model\ContactModelInterface;
use Contact\Model\EmailAddressInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
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
     * @var AuthenticationService
     */
    protected $authService;

    /**
     * AuthController constructor.
     *
     * @param Container $sessionContainer
     * @param LinkedIn $linkedInService
     * @param MemberService $memberService
     * @param AuthenticationService $authService
     */
    public function __construct(
        Container $sessionContainer,
        LinkedIn $linkedInService,
        MemberService $memberService,
        AuthenticationService $authService
    )
    {
        $this->sessionContainer = $sessionContainer;
        $this->linkedInService = $linkedInService;
        $this->memberService = $memberService;
        $this->authService = $authService;
    }

    public function indexAction()
    {
        if ($this->authService->hasIdentity()) {
            return $this->redirect()->toRoute('dashboard');
        }
        if (isset ($this->sessionContainer->accessCode)) {
            return $this->redirect()->toRoute('auth/process');
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
        return $this->redirect()->toRoute('auth/process');
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

    public function processAction()
    {
        $accessToken = $this->sessionContainer->accessCode['access_token'];

        // If no member was stored in session, let's see if we actually have it in store
        if (!isset ($this->sessionContainer->member)) {

            $options = [];

            // First we need to retrieve the data from LinkedIn
            try {
                $additionalProfile = $this->linkedInService->getAdditionalProfileDetails($accessToken, $options);
            } catch (\RuntimeException $runtimeException) {
                return $this->redirect()->toRoute('auth/problem');
            }

            $member = null;
            // Let's see if we already have this member registered
            if (!$this->memberService->isRegistered($additionalProfile)) {
                try {
                    $member = $this->memberService->registerNewMember($additionalProfile, $accessToken);
                } catch (\RuntimeException $runtimeException) {
                    return $this->redirect()->toRoute('auth/problem');
                }
            } else {
                try {
                    $member = $this->memberService->updateMember($additionalProfile, $accessToken);
                } catch (\RuntimeException $runtimeException) {
                    return $this->redirect()->toRoute('auth/problem');
                }
            }
            $this->sessionContainer->member = $member;
        }

        $result = $this->linkedInService->authenticateMember(
            $this->authService,
            $this->sessionContainer->member
        );
        if (!$result->isValid()) {
            return $this->redirect()->toRoute('auth/problem');
        }

        return $this->redirect()->toRoute('auth/welcome');
    }

    public function welcomeAction()
    {
        return new ViewModel();
    }
}
