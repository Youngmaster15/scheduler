<?php
namespace Scheduler\Pages\Controllers;

use Phalcon\Tag as Tag,
    Scheduler\Base\Controllers\ControllerBase,
    Phalcon\Mvc\View,
    Scheduler\Pages\Models\Users;
class IndexController extends ControllerBase
{
    public function indexAction()
    {
        $data['title'] = ucfirst("home");
        $data['menu_active'] = 'home';

        if ($this->request->isPost()   ) {
            $this->validation->set_rules('username','trim|required|valid_email|min_length[6]');
            $this->validation->set_rules('password','trim|required|min_length[4]');

            if ( $this->validation->run() == FALSE) {
                 $this->flashSession->error($this->validation->validation_errors());
            } else {
                $user = Users::findFirst(array(
                        'conditions' => 'email = :email:',
                        'bind' => array('email' => $this->request->getPost('username'))
                    ));
                if (! $this->security->checkHash($this->request->getPost('password'), $user->password) )  {
                    $this->flashSession->error('Password Dont Match!');
                } else {
                    $this->session->set('auth-identity', array(
                        'id' => $user->id,
                        'username' => $user->email,
                        'login' => TRUE,
                    ));
                    $this->response->redirect('admin/');
                }
            }
        }

        parent::initialize();
        $this->_setter($data);
    }

    /**
    * Page for logging out the user // redirect to main page
    *
    * @param none;
    * @return none;
    */
    public function logoutAction() {
        $this->session->remove('auth-identity');
        $this->response->redirect();
    }
}

