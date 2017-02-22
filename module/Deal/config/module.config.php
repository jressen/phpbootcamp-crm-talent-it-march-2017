<?php

namespace Deal;

use Zend\Router\Http\Literal;

return [
    'controllers' => [
        'invokables' => [
            Controller\DealController::class => Controller\DealController::class,
        ],
    ],
    'router' => [
        'routes' => [
            'deal' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/deal',
                    'defaults' => [
                        'controller' => Controller\DealController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'deal' => __DIR__ . '/../view',
        ],
    ],
];