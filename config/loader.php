<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 * Default registration for autoloaders/
 */
$loader->registerNamespaces(array(
    'Scheduler'                   => $config->application->libraryDir,
    'Scheduler\Base\Controllers'  => $config->application->baseDir .'controller/',
    'Scheduler\Pages\Controllers' => $config->application->controllersDir,
    'Scheduler\Pages\Models'      => $config->application->modelsDir
));

$loader->register();
