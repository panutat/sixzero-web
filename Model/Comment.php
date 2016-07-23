<?php

class Comment extends AppModel
{
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
        ),
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'post_id',
            'counterCache' => true,
        ),
    );

    public $validate = array(
        'message' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Comment message is required',
            ),
        ),
    );
}
