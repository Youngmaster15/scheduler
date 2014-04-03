<?php

/**
 * @author
 */

namespace Scheduler\Acl;

use Phalcon\Mvc\User\Component;
use Phalcon\Acl\Adapter\Memory as AclMemory;
use Phalcon\Acl\Role as AclRole;
use Phalcon\Acl\Resource as AclResource;
use Scheduler\Pages\Models\Roles;

class Acl extends Component {

    /**
    * Variable for private modules / controller / action
    * @access private
    * @param none;
    * @return none;
    */
    private $privateResources = Array(
        'admin' => Array(
            'index' => Array('index')
        )
    );
    /**
    * Variable for public modules / controller / action
    * @access private
    * @param none;
    * @return none;
    */
    private $publicResources = Array(
        'pages' => Array(
            'index' => Array('index', 'logout')
        )
    );
    /**
    * Variable for role (static)
    * @access private
    * @param none;
    * @return none;
    */
    private $role = Array(
            'User',
            'Guests'
    );

    /**
    * public function that will define if the method / controller / action is private
    *
    * @access public
    * @param $module;
    * @param $controller;
    * @param $action;
    *
    * @return bool;
    */
    public function is_private($module, $controller, $action) {
        if (empty($module) OR empty($controller) OR empty($action) ) return FALSE;

        // check if the $module and $controller and $action is on thee $private resources.
        foreach($this->privateResources as $moduleName => $modules){
            foreach($modules as $controllerName => $actions){
                foreach($actions as $actionName){
                    if($module == $moduleName &&
                        $controller == $controllerName &&
                        $action == $actionName){
                            return TRUE;
                    }
                }
            }
        }
        return FALSE;
    }
    private function initialize() {

    }
}