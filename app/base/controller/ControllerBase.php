<?php
namespace Scheduler\Base\Controllers;

use Phalcon\Mvc\Controller,
    Phalcon\Mvc\View,
    Phalcon\Mvc\Dispatcher;

/**
* Serve as a gateway before any controllers will load.
*
* @param none
*
* @return none
*/
class ControllerBase extends Controller {

    private $data = array();

    /**
    *
    *
    */
    public function initialize() {
        $this->data['js'] = array();
        $this->data['css'] = array();
        $this->data['less'] = array();

        $this->data['site_name'] = "Scheduler";
        $this->data['description'] = '';
        $this->data['keywords'] = '';

        //load bootstrap css
        $this->_css('/bootstrap/bootstrap.css');

        //load global.less
        $this->_less('global.less');

    }
    /**
    * Initializing the the variable that will be passed around on our pages.
    *
    * @param $data (Array) (Required)
    *
    * @return none
    **/
    protected function _setVariable($val = Array()){
        if ($val) {
            foreach($val as $key => $val) {
                $this->view->setVar($key,$val);
            }
        }
    }
    /**
    * Initializing js files that will be passed on our pages
    * default folder will on public/js
    *
    * @param $url (string) (Required)
    *
    * @return none
    **/
    protected function _js($url) {
        if(strpos($url, "http://") || strpos($url, "https://")) {
            $this->data['js'][] = $url;
        } else {
            $this->data['js'][] = $this->di['url']->getBaseUri() .  "public/js/" . $url;
        }
    }

    /**
    * Initializing css files that will be passed on our pages
    * default folder will on public/css
    *
    * @param $url (string) (Required)
    *
    * @return none
    **/
    protected function _css($url) {
        if(strpos($url, "http://") || strpos($url, "https://")) {
            $this->data['css'][] = $url;
        } else {
            $this->data['css'][] =  "public/css/" . $url;
        }
    }

    /**
    * Initializing less files that will be passed on our pages
    * default folder will on public/less
    *
    * @param $url (string) (Required)
    *
    * @return none
    **/
    protected function _less($url) {
        if(strpos($url, "http://") || strpos($url, "https://")) {
            $this->data['less'][] = $url;
        } else {
            $this->data['less'][] = $this->di['url']->getBaseUri() . "public/less/" . $url;
        }
    }
    /**
    * Initializing what view should be render on the page.
    * we wil create new instance of view because we will set the partial direcotry to our base/common_layout/partial
    *
    * @param $view (string) (Required)
    *
    * @param $data (Array) (Required) // variables
    *
    * @return $view the content in string
    **/
    private function set_partial_view($partial, $data) {
        //make sure we save the current viewDir on a variable because we need to return it back.
        $main_directory = $this->view->getViewsDir();
        $view = $this->view;

        $view->setViewsDir(__DIR__ . '/../common_layout/');

        $partial =  $view->getRender('partial', $partial, $data, function ($partial) {
            $partial->setRenderLevel(View::LEVEL_ACTION_VIEW);
        });
        // return to the default directory
        $view->setViewsDir($main_directory);

        return $partial;
    }
    /**
    * Initializing what view should be render on the page.
    * default folder will on public/less
    *
    * @param $page (string) (Required)
    *
    * @param $data (Array) (Required) // variables
    *
    * @param $tempate (string) (Required) //set template
    *
    * @return none
    **/
    protected function _setter($data = Array(), $tmp_header = "header/index", $tmp_footer = "footer/index",  $template = NULL) {
        ! $template || $this->view->setTemplateAfter($template);

        $this->data['title'] = $data['title'] . ' | ' . $this->data['site_name'];
        $this->data['header']  = $this->set_partial_view($tmp_header, $data);
        $this->data['footer']  = $this->set_partial_view($tmp_footer, $data);

        $merge = array_merge($data, $this->data);
        $this->_setVariable($merge);
        //$this->dump($this->data);
    }

     /**
     * Execute before the router so we can determine if this is a private controller, and must be authenticated, or a
     * public controller that is open to all.
     *
     * @param Dispatcher $dispatcher
     * @return boolean
     */
    public function beforeExecuteRoute(Dispatcher $dispatcher) {
        $moduleName = $dispatcher->getModuleName();
        $controllerName = $dispatcher->getControllerName();
        $actionName = $dispatcher->getActionName();

        if($this->acl->is_private($moduleName, $controllerName, $actionName)) {
            // Get the current identity
            $identity = $this->session->get('auth-identity');


            // If there is no identity available the user is redirected to index/index
            if (!is_array($identity)) {

                $this->flashSession->notice("You don't have access to the to ($moduleName / $controllerName / $actionName)");

                return $this->response->redirect();
            }

            // Check if the user have permission to the current option
            if (!$this->acl->isAllowed($identity['role'], $controllerName . '-' . $moduleName, $actionName)) {

                echo 1;
                die;

                $this->flash->notice('You don\'t have access to this module: ' . $controllerName . ':' . $actionName);

                if ($this->acl->isAllowed($identity['role'], $controllerName, $actionName)) {
                    $dispatcher->forward(array(
                        'controller' => $controllerName,
                        'action' => 'index'
                    ));
                } else {
                    $this->flash->notice('You don\'t have access to this module: ' . $controllerName . ':' . $actionName);
                    $this->response->redirect('dashboard/index');
                }

                return false;

            }
        }
    }

    /**Test**/
    public function dump($var) {
        echo "<pre>";
        print_r($var);
        echo "</pre>";
    }
}