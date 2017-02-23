<?php

namespace Company;

use Zend\Router\Http\Literal;

return [
    'controllers' => [
        'invokables' => [
            Controller\CompanyController::class => Controller\CompanyController::class,
        ],
    ],
    'router' => [
        'routes' => [
            'company' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/company',
                    'defaults' => [
                        'controller' => Controller\CompanyController::class,
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
            'company' => __DIR__ . '/../view',
        ],
    ],
];