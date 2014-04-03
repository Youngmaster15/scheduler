<?php

error_reporting(E_ALL);

define('BASE_DIR', __DIR__ . "/..");
define('APP_DIR', BASE_DIR . '/app');
define('BASE_URL', $_SERVER['SERVER_NAME'] . '/' . $_SERVER['REQUEST_URI']);
define('BASE_URI',  $_SERVER['REQUEST_URI']);
/**
*  Bootstrap / Will load all configuration file needed
*
* @param none;
*
* @return none;
*/
class Application extends Phalcon\Mvc\Application {

    public function __construct() {
        parent::__construct();
        try {

            date_default_timezone_set('Asia/Manila');
            $this->_register_services();

           //Register the installed modules
           $this->registerModules(array(
                'pages' => array(
                    'className' => 'Scheduler\Pages\Module',
                    'path' => APP_DIR . '/pages/Module.php'
                ),
                'admin' => array(
                    'className' => 'Scheduler\Admin\Module',
                    'path' => APP_DIR . '/admin/Module.php'
                )
           ));

           echo $this->handle()->getContent();

        } catch (Phalcon\Exception $e) {
            echo $e->getMessage();
        }
    }

}

$application = new Application();
