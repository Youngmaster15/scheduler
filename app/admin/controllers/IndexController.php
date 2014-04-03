<?php
namespace Scheduler\Admin\Controllers;

use Phalcon\Tag as Tag,
    Scheduler\Base\Controllers\ControllerBase,
    Phalcon\Mvc\View;
class IndexController extends ControllerBase
{
    public function indexAction()
    {
        $data['title'] = ucfirst("admin");
        $data['menu_active'] = 'admin';
        $data['user'] = $this->session->get('auth-identity');
        parent::initialize();
        $this->_setter($data, 'header/admin');
    }
}

