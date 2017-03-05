<?php

namespace Contact;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'controllers' => [
        'factories' => [
            Controller\ContactController::class => Controller\Factory\ContactControllerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'contact' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/contact',
                    'defaults' => [
                        'controller' => Controller\ContactController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'overview' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/overview[/page/:page]',
                            'defaults' => [
                                'action' => 'overview',
                                'page' => 1,
                            ],
                            'constraints' => [
                                'page' => '\d+',
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
    'service_manager' => [
        'aliases' => [
            Model\ContactModelInterface::class => Model\ContactModel::class,
        ],
        'factories' => [
            Model\ContactModel::class => Model\Factory\ContactModelFactory::class,
        ],
    ],
];