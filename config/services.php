<?php

use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;

use Scheduler\Acl\Acl;
use Scheduler\Validation\Validation;
/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
}, true);

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
    return new DbAdapter(array(
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname
    ));
});

/**
 * Register configuration file so we will have access to our error message and and base_url
 */
$di->set('config', function () use ($config) {
    return $config;
});
/**
 * Setting up the view component
 */
$di->set('view', function () use ($config) {

    $view = new View();

    $view->registerEngines(array(
        '.volt' => function ($view, $di) use ($config) {

            $volt = new VoltEngine($view, $di);

            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ));

            return $volt;
        },
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    ));

    return $view;
});

/**
 * Start the session the first time some component request the session service
 */
$di->set('crypt', function () use ($config) {
    $crypt = new Phalcon\Crypt();
    $crypt->setKey( $config->application->salt);

    return $crypt;
});

/**
* register configuration file for flash
*/
$di->set('flashSession', function() {
    return new Phalcon\Flash\Session(array(
        'error'     => 'alert alert-danger',
        'success'   => 'alert alert-success',
        'notice'    => 'alert alert-info',
    ));
});
/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

/**
* We need to set our ACL Configuration libaray
*/
$di->set('acl', function() {
    return new Acl();
});

/**
* We need to set up our Validation Configuration libaray
*/
$di->set('validation', function() {
    return new Validation();
});