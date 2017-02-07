<?php

namespace Contact;

use Contact\Factory\ZendDbSqlRepositoryFactory;
use Contact\Model\ContactRepository;
use Contact\Model\ContactRepositoryInterface;
use Contact\Model\ZendDbSqlRepository;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'aliases' => [
            ContactRepositoryInterface::class => ZendDbSqlRepository::class,
        ],
        'factories' => [
            ContactRepository::class => InvokableFactory::class,
            ZendDbSqlRepository::class => ZendDbSqlRepositoryFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\ContactController::class => Factory\ContactControllerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'contact' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/contact[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '\d+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ContactController::class,
                        'action' => 'index',
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