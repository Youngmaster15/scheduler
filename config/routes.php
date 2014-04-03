<?php

$di->set('router', function(){

    $router  = new Phalcon\Mvc\Router();

    $router->setDefaultModule("pages");

    $router->add('/', array(
        'module'     => 'pages',
        'controller' => 'index',
        'action'     => 'index'
    ));

    $router->add('/admin', array(
        'module'     => 'admin',
        'controller' => 'index',
        'action'     => 'index'
    ));

    $router->add("/admin/:controller", array(
        'module' => 'admin',
        'controller' => 1,
        'action' => 'index',
    ));

    $router->add("/admin/:controller/:action", array(
        'module' => 'admin',
        'controller' => 1,
        'action' => 2,
    ));


    $router->add("/admin/:controller/:action/:params", array(
        'module' => 'admin',
        'controller' => 1,
        'action' => 2,
        'params' => 3
    ));


    //let's try to remove the last slash in our URI
    $router->removeExtraSlashes(true);

    return $router;
});