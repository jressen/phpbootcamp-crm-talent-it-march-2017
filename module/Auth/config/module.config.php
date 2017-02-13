<?php

namespace Auth;

use Zend\Router\Http\Literal;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'aliases' => [
            Entity\MemberInterface::class => Entity\MemberEntity::class,
        ],
        'factories' => [
            \Zend\Session\Config\ConfigInterface::class => \Zend\Session\Service\SessionConfigFactory::class,
            Service\LinkedIn::class => Service\Factory\LinkedInFactory::class,
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
            'contact' => __DIR__ . '/../view',
        ],
    ],
];