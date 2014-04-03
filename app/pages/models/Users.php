<?php

namespace Scheduler\Pages\Models;

use Phalcon\Mvc\Model\Validator\Email as Email;

class Users extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $created;
         public function validation()
    {

        $this->validate(
            new Email(
                array(
                    "field"    => "email",
                    "required" => true,
                )
            )
        );
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
    public function initialize()
    {
		$this->hasMany("id", "Learnings", "user_id", NULL);
		$this->hasMany("id", "Todos", "user_id", NULL);

    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id',
            'email' => 'email',
            'password' => 'password',
            'created' => 'created'
        );
    }

}
