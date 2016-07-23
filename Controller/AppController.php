<?php
/**
 * Application level Controller.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         CakePHP(tm) v 0.2.9
 *
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/*
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
App::import('Lib', 'Facebook.FB');
class AppController extends Controller
{
    public $helpers = array('Facebook.Facebook');

    public $components = array(
        'Session',
        'Cookie',
        'Facebook.Connect',
        'DebugKit.Toolbar',
    );

    public $uses = array('User', 'Channel');

    protected $_guestAllowedURLs = array();

    public function beforeFilter()
    {
        parent::beforeFilter();

        // Check cookie for login
        if (!$this->_isUserLoggedIn() && $this->Cookie->read('keep_me_logged_in')) {
            $cookie = $this->Cookie->read('keep_me_logged_in');
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.email_addr' => $cookie['email_addr'],
                    'User.password' => $cookie['password'],
                ),
            ));
            if ($user) {
                $fb_user = $this->Connect->user();
                $this->_setSessionUser($user);
                $this->redirect(array('controller' => 'home', 'action' => 'index'));
            }
        }

        if (!$this->_isUserLoggedIn() && !$this->_isGuestAllowedURL($this->request->params['controller'], $this->request->params['action'])) {
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

        $this->_setAdminChannels();
        $this->_setUserChannels();

        $this->set('user', $this->_getSessionUser());
    }

    protected function _isUserLoggedIn()
    {
        if ($this->_getSessionUser()) {
            return true;
        }

        return false;
    }

    protected function _isGuestAllowedURL($controller, $action)
    {
        if (array_key_exists($controller, $this->_guestAllowedURLs)) {
            if (in_array($action, $this->_guestAllowedURLs[$controller])) {
                return true;
            }
        }

        return false;
    }

    protected function _getSessionUser()
    {
        return $this->_sessionRead(self::SESSION_KEY_USER);
    }

    protected function _setSessionUser($user)
    {
        $this->_sessionWrite(self::SESSION_KEY_USER, $user);
    }

    protected function _deleteSessionUser()
    {
        $this->_sessionDelete(self::SESSION_KEY_USER);
    }

    protected function _sessionRead($key)
    {
        return $this->Session->read($key);
    }

    protected function _sessionWrite($key, $value)
    {
        $this->Session->write($key, $value);
    }

    protected function _sessionDelete($key)
    {
        $this->Session->delete($key);
    }

    protected function _setFlashMessage($message, $type, $errors = null)
    {
        $params = array('class' => $type);
        if ($errors) {
            $params = array_merge($params, array('errors' => $errors));
        }
        $this->Session->setFlash($message, 'message', $params);
    }

    protected function _getAdminUser()
    {
        if (!$this->_sessionRead(self::SESSION_KEY_ADMIN)) {
            $admin = $this->User->find('first', array(
                'conditions' => array('User.id' => Configure::read('Admin.user_id')),
            ));
            $this->_sessionWrite(self::SESSION_KEY_ADMIN, $admin);
        }

        return $this->_sessionRead(self::SESSION_KEY_ADMIN);
    }

    protected function _getAdminChannels()
    {
        $channels = $this->Channel->find('all', array(
            'conditions' => array(
                'Channel.user_id' => Configure::read('Admin.user_id'),
                'Channel.active' => true,
            ),
            'order' => array('Channel.name' => 'ASC'),
        ));

        return $channels;
    }

    protected function _getUserChannels()
    {
        $user = $this->_getSessionUser();
        $user_channels = $this->Channel->find('all', array(
            'conditions' => array(
                'Channel.user_id' => $user['User']['id'],
                'Channel.active' => true,
            ),
            'order' => array('Channel.name' => 'ASC'),
        ));

        return $user_channels;
    }

    protected function _setUserChannels()
    {
        $this->set(self::SESSION_KEY_USER_CHANNELS, $this->_getUserChannels());
    }

    protected function _setAdminChannels()
    {
        $this->set(self::SESSION_KEY_ADMIN_CHANNELS, $this->_getAdminChannels());
    }

    protected function _parseDuration($str)
    {
        $result = array();
        preg_match('/^(?:P)([^T]*)(?:T)?(.*)?$/', trim($str), $sections);
        if (!empty($sections[1])) {
            preg_match_all('/(\d+)([YMWD])/', $sections[1], $parts, PREG_SET_ORDER);
            $units = array('Y' => 'years', 'M' => 'months', 'W' => 'weeks', 'D' => 'days');
            foreach ($parts as $part) {
                $result[$units[$part[2]]] = $part[1];
            }
        }
        if (!empty($sections[2])) {
            preg_match_all('/(\d+)([HMS])/', $sections[2], $parts, PREG_SET_ORDER);
            $units = array('H' => 'hours', 'M' => 'minutes', 'S' => 'seconds');
            foreach ($parts as $part) {
                $result[$units[$part[2]]] = $part[1];
            }
        }

        return $result;
    }

    const SESSION_KEY_USER = 'user';
    const SESSION_KEY_ADMIN = 'admin';
    const SESSION_KEY_ADMIN_CHANNELS = 'admin_channels';
    const SESSION_KEY_USER_CHANNELS = 'user_channels';
}
