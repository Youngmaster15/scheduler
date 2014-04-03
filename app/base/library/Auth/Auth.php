<?php

/**
 * @author jRr
 * @created Feb 6 2014
 */

namespace Bingly\Auth;

use Phalcon\Mvc\User\Component;
use Bingly\Dashboard\Models\Users as Users;

class Auth extends Component {

	/**
     * Checks the user credentials
     *
     * @param array $credentials
     * @return boolan
     */
    public function check($credentials)
    {

        // Check if the user exist
        $user = Users::findFirst('username = "'.$credentials['username'].'"');

        if ($user == false) {
            throw new Exception('Wrong username');
        }

        // Check the password
        if (!$this->security->checkHash($credentials['password'], $user->password)) {
            throw new Exception('Wrong email/password combination');
        }

        $this->session->set('auth-identity', array(
            'id' => $user->id,
            'name' => $user->firstname,
            'role' => $user->roles->name,
            'userData' => $user->toArray(),
            'organization_id' => $user->organizations->organization_id
        ));
    }

    /**
     * Returns the current identity
     *
     * @return array
     */
    public function getIdentity()
    {
        return $this->session->get('auth-identity');
    }

    /**
     * Removes the user identity information from session
     */
    public function remove()
    {
        $this->session->remove('auth-identity');
    }

    protected function pr($value){
        echo '<pre>';
        print_r($value);
        echo '</pre>';
    }

}