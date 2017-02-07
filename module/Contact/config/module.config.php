<?php

namespace Contact;

use Contact\Factory\ZendDbSqlCommandFactory;
use Contact\Factory\ZendDbSqlRepositoryFactory;
use Contact\Model\ContactCommand;
use Contact\Model\ContactCommandInterface;
use Contact\Model\ContactRepository;
use Contact\Model\ContactRepositoryInterface;
use Contact\Model\ZendDbSqlCommand;
use Contact\Model\ZendDbSqlRepository;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'aliases' => [
            ContactRepositoryInterface::class => ZendDbSqlRepository::class,
            ContactCommandInterface::class => ZendDbSqlCommand::class,
        ],
        'factories' => [
            ContactRepository::class => InvokableFactory::class,
            ContactCommand::class => InvokableFactory::class,
            ZendDbSqlRepository::class => ZendDbSqlRepositoryFactory::class,
            ZendDbSqlCommand::class => ZendDbSqlCommandFactory::class,
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