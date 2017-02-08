<?php

namespace Contact;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'service_manager' => [
        'aliases' => [
            Model\ContactRepositoryInterface::class => Model\ContactRepository::class,
            Model\ContactCommandInterface::class => Model\ContactCommand::class,
            Model\ContactEmailRepositoryInterface::class => Model\ContactEmailRepository::class,
        ],
        'factories' => [
            Model\ContactRepository::class => Factory\ContactRepositoryFactory::class,
            Model\ContactCommand::class => Factory\ContactlCommandFactory::class,
            Model\ContactEmailRepository::class => Factory\ContactEmailRepositoryFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\ContactController::class => Factory\ContactControllerFactory::class,
            Controller\ContactWriteController::class => Factory\ContactWriteControllerFactory::class,
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
                    'detail' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/detail/:id',
                            'defaults' => [
                                'action' => 'detail',
                            ],
                            'constraints' => [
                                'id' => '\d+',
                            ],
                        ],
                    ],
                    'add' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/add',
                            'defaults' => [
                                'controller' => Controller\ContactWriteController::class,
                                'action' => 'add',
                            ],
                        ],
                    ],
                    'edit' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/edit/:id',
                            'defaults' => [
                                'controller' => Controller\ContactWriteController::class,
                                'action' => 'edit',
                            ],
                            'constraints' => [
                                'id' => '\d+',
                            ],
                        ],
                    ],
                    'delete' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/delete/:id',
                            'defaults' => [
                                'controller' => Controller\ContactWriteController::class,
                                'action' => 'delete',
                            ],
                            'constraints' => [
                                'id' => '\d+',
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