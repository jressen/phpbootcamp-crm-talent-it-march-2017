<?php

namespace Contact;

use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    /*'controllers' => [
        'factories' => [
            Controller\ContactController::class => InvokableFactory::class,
        ],
    ],*/
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