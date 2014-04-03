<?php

namespace Scheduler\Admin;

use Phalcon\Mvc\View\Engine\Volt as VoltEngine;

class Module
{

    public function registerAutoloaders()
    {

        $loader = new \Phalcon\Loader();

        $loader->registerNamespaces(array(
            'Scheduler\Admin\Controllers' => __DIR__  . "/../../app/admin/controllers/",
            'Scheduler\Admin\Models' => __DIR__  . "/../../app/admin/models/",
        ), TRUE);

        $loader->register();
    }

    /**
     * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
     */
    public function registerServices($di)
    {

        $config = include __DIR__  . "/../../config/config.php";
        //Registering a dispatcher
        $di->set('dispatcher', function () {
            $dispatcher = new \Phalcon\Mvc\Dispatcher();

            //Attach a event listener to the dispatcher
            //$eventManager = new \Phalcon\Events\Manager();
            $dispatcher->setDefaultNamespace("Scheduler\Admin\Controllers\\");
            return $dispatcher;
        });

        /**
        * Set the view
        */
         $di['view']->setViewsDir(__DIR__ . '/views/');
         $di['view']->setLayoutsDir('../../../app/base/common_layout/');
         $di['view']->setLayout('main');

        //register db service for bingly main
        $di->set('modelsManager', function () {
            return new \Phalcon\Mvc\Model\Manager();
        });
    }

}