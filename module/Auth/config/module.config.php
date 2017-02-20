<?php

namespace Auth;

use Zend\Router\Http\Literal;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'invokables' => [
            \Zend\Authentication\AuthenticationService::class => \Zend\Authentication\AuthenticationService::class,
        ],
        'aliases' => [
            Entity\MemberInterface::class => Entity\MemberEntity::class,
            Adapter\LinkedinAdapterInterface::class => Adapter\LinkedinAdapter::class,
        ],
        'factories' => [
            \Zend\Session\Config\ConfigInterface::class => \Zend\Session\Service\SessionConfigFactory::class,
            Service\LinkedIn::class => Service\Factory\LinkedInFactory::class,
            Service\MemberService::class => Service\Factory\MemberServiceFactory::class,
            Model\MemberModel::class => Model\Factory\MemberModelFactory::class,
            Adapter\LinkedinAdapter::class => Adapter\Factory\LinkedinAdapterFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AuthController::class => Controller\Factory\AuthControllerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'auth' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/auth',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'callback' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/callback',
                            'defaults' => [
                                'action' => 'callback',
                            ],
                        ],
                    ],
                    'process' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/process',
                            'defaults' => [
                                'action' => 'process',
                            ],
                        ],
                    ],
                    'problem' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/problem',
                            'defaults' => [
                                'action' => 'problem',
                            ],
                        ],
                    ],
                    'cancelled' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/cancelled',
                            'defaults' => [
                                'action' => 'cancelled',
                            ],
                        ],
                    ],
                    'welcome' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/welcome',
                            'defaults' => [
                                'action' => 'welcome',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'auth' => __DIR__ . '/../view',
        ],
    ],
];