<?php

class User extends AppModel
{
    public $validate = array(
        'facebook_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A Facebook ID is required',
            ),
        ),
        'first_name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A first name is required',
            ),
            'between' => array(
                'rule' => array('between', 2, 20),
                'message' => 'First name must be 2 to 20 characters',
            ),
        ),
        'last_name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A last name is required',
            ),
            'between' => array(
                'rule' => array('between', 2, 20),
                'message' => 'Last name must be 2 to 20 characters',
            ),
        ),
        'email_addr' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'An email address is required',
            ),
            'email' => array(
                'rule' => array('email'),
                'message' => 'A valid email address is required',
            ),
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required',
            ),
            'between' => array(
                'rule' => array('between', 6, 20),
                'message' => 'Password must be 6 to 20 characters',
            ),
        ),
        'salt' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A salt is required',
            ),
        ),
    );
}
