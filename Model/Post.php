<?php

class Post extends AppModel
{
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
        ),
        'SiteChannel' => array(
            'className' => 'Channel',
            'foreignKey' => 'site_channel_id',
        ),
        'UserChannel' => array(
            'className' => 'Channel',
            'foreignKey' => 'user_channel_id',
        ),
    );

    public $validate = array(
        'video_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A Video ID is required',
            ),
        ),
    );
}
