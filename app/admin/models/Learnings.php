<?php




class Learnings extends \Phalcon\Mvc\Model
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
    public $learned;

    /**
     *
     * @var string
     */
    public $date;

    /**
     *
     * @var integer
     */
    public $user_id;

    public function initialize()
    {
		$this->belongsTo("user_id", "Users", "id", NULL);

    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id',
            'learned' => 'learned',
            'date' => 'date',
            'user_id' => 'user_id'
        );
    }

}
