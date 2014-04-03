<?php

namespace Scheduler\Validation;

/**
*   We will not use any validation from \Phalcon\Validation since getMessage cannot  be alter once it is validte.. it wil produce error
*   Contiuously once we already put it in.
*
*   Rule                Parameter   Description                                                                                                         Example
*   required            No          Returns FALSE if the form element is empty.
*   matches             Yes         Returns FALSE if the form element does not match the one in the parameter.                                          matches[form_item]
*   is_unique           Yes         Returns FALSE if the form element is not unique to the table and field name in the parameter.                       is_unique[table.field] //Not yet done
*   min_length          Yes         Returns FALSE if the form element is shorter then the parameter value.                                              min_length[6]
*   max_length          Yes         Returns FALSE if the form element is longer then the parameter value.                                               max_length[12]
*   exact_length        Yes         Returns FALSE if the form element is not exactly the parameter value.                                               exact_length[8]
*   greater_than        Yes         Returns FALSE if the form element is less than the parameter value or not numeric.                                  greater_than[8]
*   less_than           Yes         Returns FALSE if the form element is greater than the parameter value or not numeric.                               less_than[8]
*   alpha               No          Returns FALSE if the form element contains anything other than alphabetical characters.
*   alpha_numeric       No          Returns FALSE if the form element contains anything other than alpha-numeric characters.
*   alpha_dash          No          Returns FALSE if the form element contains anything other than alpha-numeric characters, underscores or dashes.
*   numeric             No          Returns FALSE if the form element contains anything other than numeric characters.
*   is_natural          No          Returns FALSE if the form element contains anything other than a natural number: 0, 1, 2, 3, etc.
*   is_natural_no_zero  No          Returns FALSE if the form element contains anything other than a natural number, but not zero: 1, 2, 3, etc.
*   valid_email         No          Returns FALSE if the form element does not contain a valid email address.
*/
use Phalcon\Validation\Validator\PresenceOf,
    Phalcon\Validation\Validator\Email,
    Phalcon\Validation\Validator\Identical,
    Phalcon\Validation\Validator\Between,
    Phalcon\Validation\Validator\StringLength,
    Phalcon\Validation\Validator\Confirmation;
/**
* Library for validation extended use of validation by phalcon.
*
*/
class Validation extends \Phalcon\Validation {
    /**
    * Variable where we save the global variable for all the fields we have.
    *@param none
    *@return none
    */
    protected $_field_data = Array();
    /**
    * Variable where we save the global variable for error message
    *@param none
    *@return none
    */
    private $_err_message = Array();
    /**
    * Variable for the predifined validation error message
    *@param none
    *@return none
    */
    protected  $_predefined_error_message = Array();

    /**
    * Variable for the default error message from config file.
    *@param none
    *@return none
    */
    private $default_error_messages = Array();

    /**
    * Variable for the default prefix
    *@param none
    *@return none
    */
    private $error_preffix = '<p>';
    /**
    * Variable for the default suffix
    *@param none
    *@return none
    */
    private $error_suffix = '</p>';
    /**
    * function for initialization we make sure to load the error message we have on our config! required!
    *
    * @param none
    *
    * @return none
    */
    private function initialize() {
        if (! isset($this->config->error_messages))
            die("Please make sure to include the error configuration");

        $this->default_error_messages = $this->config->error_messages;
    }

   /**
    * function that will set the rules per each POST info.
    *
    * @access public
    *
    * @param $key
    *
    * @param $value
    *
    * @return custom error mesage
    */
    public function set_rules($field, $rules,  $name = '') {
        //make sure fields exist; else we exit.
        if ( empty($field) OR !array_key_exists($field, $_POST)) return $this;

        //make sure $rules exist
        $rules = explode("|", $rules);

        //count 0 then no need to proceed.
        if (!$rules)  return $this;

        //if label is not define then we will base it on the field name.
        $name = ($name == '' ) ? ucfirst($field) : $name;

        $this->_field_data[$field] = array(
            'field' => $field,
            'name' => $name,
            'rules' => $rules
        );

        return $this;
    }
   /**
    * function that will replace the error message on our container
    *
    * @access public
    *
    * @param $key
    *
    * @param $value
    *
    * @return custom error mesage
    */
    public function set_message($key, $value) {
        //make sure that key and value is important;
        if (empty($key) OR empty($value))  return $this;

        $this->default_error_messages[$key] = $value;

        return $this;
    }
   /**
    * function that will check if the field is empty
    *
    * @access public
    *
    * @param none; sooner or later we will add group on w/c criteria will run.
    *
    * @return run if theres error defined
    */
    public function run($group = '') {
        //check also if there's field define by our set_rule function
        if (count ($this->_field_data) === 0 ) return FALSE;

        //reference post, any changes will affect the post data.
        $post_ref =& $_POST;

        //since we have records then we were gonna iterate each rule to it's function and check for validation.
        foreach($this->_field_data as $key => $val) {
            //make sure $rules exist
            foreach($val['rules'] as $rule) {
                $variable =  NULL;
                //check if we have variable inlcuded. if we detect "["
                if (strpos($rule,'[')) {
                    $explode = explode("[", $rule);
                    $rule = $explode[0];
                    $variable = trim(str_replace(Array("[","]"),"", $explode[1]));

                    //$variable = trim(str_replace(array("[","]"),"",end(explode("[", $rule))));
                }
                //if rule exist then we will run the validation.
                if (method_exists($this, $rule)) {
                    $execute = $this->$rule($post_ref , $key, $variable);
                    if ($execute === FALSE) {
                        $this->_predefined_error_message[] = sprintf($this->default_error_messages[$rule], $this->_field_data[$key]['name'], ($variable === NULL) ? '' : ucfirst($variable));
                    }
                }
            }
        }

        return $this->execute();
    }

   /**
    * function  that will return all the error messages.
    *
    * @access public
    *
    * @param $none
    *
    * @return save to static $_err
    */
    public function validation_errors($prefix = '' , $suffix = '') {
        //make sure  we have posts before passing validation.
        if (count($_POST) == 0) return '';

        $prefix = ($prefix == '') ? $this->error_preffix : $prefix;
        $suffix = ($suffix == '') ? $this->error_suffix : $suffix;

        $message = '';
        //make sure therer error on our err varialble
        foreach($this->_err_message as $err) {
            $message .= $prefix . $err . $suffix;
        }
        return $message;
    }

    /**
    *---------------------------------------------------------------------------
    * Private function **Rules**
    *---------------------------------------------------------------------------
    */

    /**
    * function that will check if the field is empty ( phalcon )
    *
    * @access private
    *
    * @param $field
    *
    * @param $key
    *
    * @return register to our validation
    */
    private function required($field, $key ) {
        return (empty($field[$key])) ? FALSE : TRUE;
    }

    // --------------------------------------------------------------------

    /**
    * function that will check if the field is a valid email
    *
    * @access private
    *
    * @param $field
    *
    * @param $key
    *
    * @return register to our validation
    */
    private function valid_email($field, $key ) {
       /**
       * for some reason phalcon email validator is not responding well in terms of criteria so we use a preg_match
       * sample : something.something@gmail.com13123
       */
        /*$this->add($key, new Email());

       $this->validate($_POST);

       return $this->is_error((bool) (count(parent::getMessages())));*/
       return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $field[$key])) ? FALSE : TRUE;
    }

    // --------------------------------------------------------------------

    /**
    * function that will check if legnht of the string is greater than what we have. ( phalcon )
    *
    * @access private
    *
    * @param $field
    *
    * @param $key
    *
    * @return register to our validation
    */
    private function max_length($field, $key, $variable ) {
       return strlen($field[$key]) <= (int) $variable;
    }

    // --------------------------------------------------------------------

    /**
    * function that will check if legnht of the string is lesser than what we have.
    *
    * @access private
    *
    * @param $field
    *
    * @param $key
    *
    * @return register to our validation
    */
    private function min_length($field, $key, $variable ) {
       return strlen($field[$key]) >= (int) $variable;
    }

   // --------------------------------------------------------------------

   /**
    * function that will check if legnht of the string is greater than what we have. ( phalcon )
    *
    * @access private
    *
    * @param $field
    *
    * @param $key
    *
    * @return register to our validation
    */
    private function exact_length($field, $key, $variable ) {
       return strlen($field[$key]) == (int) $variable;
    }

   // --------------------------------------------------------------------

   /**
    * make sure data will have no extra spaces. ( custom )
    *
    * @access private
    *
    * @param $field
    *
    * @param $key
    *
    * @return save to static $_err
    */
    private function trim(&$field, $key) {
        $field[$key] = trim($field[$key]);
    }

    // --------------------------------------------------------------------

   /**
    * function that will check if the input value is only character (custom)
    *
    * @access private
    *
    * @param $field
    *
    * @param $key
    *
    * @return register to our validation
    */
    private function alpha($field, $key) {
        return (bool) ( ! preg_match("/^([a-z])+$/i", $field[$key])) ? FALSE : TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Alpha-numeric
     *
     * @access  private
     * @param   string
     * @return  bool
     */
    private function alpha_numeric($field, $key) {
        return ( ! preg_match("/^([a-z0-9])+$/i", $field[$key])) ? FALSE : TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Alpha-numeric with underscores and dashes
     *
     * @access  private
     * @param   string
     * @return  bool
     */
    private function alpha_dash($field, $key) {
        return ( ! preg_match("/^([-a-z0-9_-])+$/i", $field[$key])) ? FALSE : TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Numeric
     *
     * @access  private
     * @param   string
     * @return  bool
     */
    private function numeric($field, $key) {
        return (bool)preg_match( '/^[\-+]?[0-9]*\.?[0-9]+$/', $field[$key]);
    }

    // --------------------------------------------------------------------
    /**
     * Is a Natural number  (0,1,2,3, etc.)
     *
     * @access  private
     * @param   string
     * @return  bool
     */
    private function is_natural($field, $key) {
        return (bool) preg_match( '/^[0-9]+$/', $field[$key]);
    }

    // --------------------------------------------------------------------

    /**
     * Is a Natural number, but not a zero  (1,2,3, etc.)
     *
     * @access  private
     * @param   string
     * @return  bool
     */
    private function is_natural_no_zero($field, $key)
    {
        if ( ! preg_match( '/^[0-9]+$/', $field[$key]))
        {
            return FALSE;
        }

        if ($field[$key] == 0)
        {
            return FALSE;
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Greather than
     *
     * @access  private
     * @param   string
     * @return  bool
     */
    private function greater_than($field, $key, $min)
    {
        if ( ! is_numeric($field[$key]))
        {
            return FALSE;
        }
        return $field[$key] > $min;
    }

    // --------------------------------------------------------------------

    /**
     * Less than
     *
     * @access  private
     * @param   string
     * @return  bool
     */
    private function less_than($field, $key, $max)
    {
        if ( ! is_numeric($field[$key]))
        {
            return FALSE;
        }
        return $field[$key] < $max;
    }

    // --------------------------------------------------------------------

    /**
     * Match one field to another
     *
     * @access  public
     * @param   string
     * @param   field
     * @return  bool
     */
    public function matches($field, $key, $match)
    {
        if ( ! isset($_POST[$match]))
        {
            return FALSE;
        }

        return ($field[$key] !== $_POST[$match]) ? FALSE : TRUE;
    }
    // --------------------------------------------------------------------

    /**
     * Performs a Regular Expression match test.
     *
     * @access  private
     * @param   string
     * @param   regex
     * @return  bool
     */
    private function regex_match($field, $key, $regex)
    {
        if ( ! preg_match($field[$key], $str))
        {
            return FALSE;
        }

        return  TRUE;
    }

   /**
    * private function that will execute the validation.
    *
    * @access private
    *
    * @param none
    *
    * @return TRUE || FALSE
    */
    private function execute() {
        //reset fields_data vaules for next instance
        $this->fields_data = array();
        $this->_err_message = array();

        // make sure that there will be no duplicate on error messages.
        $this->_err_message = array_unique($this->_predefined_error_message);

        return (count($this->_err_message) == 0) ? TRUE : FALSE;
    }
}