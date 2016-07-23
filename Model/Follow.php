<?php

class Follow extends AppModel
{
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
        ),
        'Follower' => array(
            'className' => 'User',
            'foreignKey' => 'follower_id',
        ),
    );
}
