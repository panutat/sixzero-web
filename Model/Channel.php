<?php

class Channel extends AppModel
{
    public $belongsTo = array(
        'User',
    );

    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A channel name is required',
            ),
            'between' => array(
                'rule' => array('between', 2, 25),
                'message' => 'Channel name must be 2 to 45 characters',
            ),
        ),
    );
}
