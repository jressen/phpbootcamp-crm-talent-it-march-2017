<?php

namespace Contact;


use Contact\Model\Contact;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\ContactTable::class => function($container) {
                    $tableGateway = $container->get(Model\ContactTableGateway::class);
                    return new Model\ContactTable($tableGateway);
                },
                Model\ContactTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Contact());
                    return new TableGateway('contact', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\ContactController::class => function($container) {
                    return new Controller\ContactController(
                        $container->get(Model\ContactTable::class)
                    );
                },
            ],
        ];
    }
}