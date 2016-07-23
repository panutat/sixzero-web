<?php

class Tag extends AppModel
{
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
        ),
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'post_id',
        ),
    );
}
