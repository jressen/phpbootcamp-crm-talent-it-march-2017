<?php

namespace Dashboard;

use Zend\Router\Http\Literal;

return [
    'controllers' => [
        'factories' => [
            Controller\DashboardController::class => Controller\Factory\DashboardControllerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'dashboard' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/dashboard',
                    'defaults' => [
                        'controller' => Controller\DashboardController::class,
                        'action' => 'overview',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'contacts' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/contacts',
                            'defaults' => [
                                'action' => 'contacts',
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