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
            Model\ContactAddressRepositoryInterface::class => Model\ContactAddressRepository::class,
        ],
        'factories' => [
            Model\ContactRepository::class => Model\Factory\ContactRepositoryFactory::class,
            Model\ContactCommand::class => Model\Factory\ContactlCommandFactory::class,
            Model\ContactEmailRepository::class => Model\Factory\ContactEmailRepositoryFactory::class,
            Model\ContactAddressRepository::class => Model\Factory\ContactAddressRepositoryFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\ContactController::class => Controller\Factory\ContactControllerFactory::class,
            Controller\ContactWriteController::class => Controller\Factory\ContactWriteControllerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'contact' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/contact[/page/:page]',
                    'defaults' => [
                        'controller' => Controller\ContactController::class,
                        'action' => 'index',
                        'page' => 1,
                    ],
                    'constraints' => [
                        'page' => '\d+',
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
        'template_map' => [
            'paginator-slide' => __DIR__ . '/../view/layout/slidePaginator.phtml',
        ],
    ],
];