<?php

class UsersController extends AppController
{
    public $uses = array('Post', 'Follow', 'Channel');

    public $components = array('Youtube');

    protected $_guestAllowedURLs = array(
        'users' => array('login', 'register'),
    );

    public function login()
    {
        if ($this->request->isPost()) {
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.email_addr' => $this->request->data['User']['email_addr'],
                ),
            ));
            if ($user) {
                $password = crypt($this->request->data['User']['password'], self::BLOWFISH_PRE.$user['User']['salt'].self::BLOWFISH_END);
                if ($password === $user['User']['password']) {
                    if ($this->request->data['User']['keep_me_logged_in']) {
                        $cookie = array();
                        $cookie['email_addr'] = $this->request->data['User']['email_addr'];
                        $cookie['password'] = $user['User']['password'];
                        $this->Cookie->write('keep_me_logged_in', $cookie, true, '2 weeks');
                    }

                    $this->_setSessionUser($user);
                    $this->redirect(array('controller' => 'home', 'action' => 'index'));
                }
            }
            $this->_setFlashMessage('Login failed. Please try again', 'alert');
        }
        $this->layout = 'login';
    }

    public function register()
    {
        $fb_user = $this->Connect->user();
        if ($fb_user) {
            if ($this->request->isPost()) {
                $this->request->data('User.first_name', $fb_user['first_name']);
                $this->request->data('User.last_name', $fb_user['last_name']);
                $this->request->data('User.email_addr', $fb_user['email']);
                $this->request->data('User.facebook_id', $fb_user['id']);
                $this->request->data('User.gender', $fb_user['gender']);

                // Check if user already exists
                $user_exists = $this->User->find('count', array(
                    'conditions' => array('User.email_addr' => $this->request->data['User']['email_addr']),
                ));

                if ($user_exists) {
                    $this->_setFlashMessage('Account already exists.', 'alert');
                } elseif (!empty($this->request->data['User']['password']) && $this->request->data['User']['password'] === $this->request->data['User']['confirm']) {
                    // Validate
                    $this->User->set($this->request->data);
                    if ($this->User->validates(array('fieldList' => array('first_name', 'last_name', 'email_addr', 'password')))) {
                        // Encrypt password
                        $salt = $this->_generateSalt();
                        $password = crypt($this->request->data['User']['password'], self::BLOWFISH_PRE.$salt.self::BLOWFISH_END);
                        $this->request->data('User.password', $password);
                        $this->request->data('User.salt', $salt);

                        if ($this->User->save($this->request->data, false)) {
                            $this->_setFlashMessage('Registration successful.', 'success');
                            $user_id = $this->User->getLastInsertID();
                            $user = $this->User->find('first', array(
                                'conditions' => array('User.id' => $user_id),
                            ));
                            $this->_setSessionUser($user);
                            $this->redirect(array('controller' => 'home', 'action' => 'index'));
                        }
                    } else {
                        $errors = $this->User->validationErrors;
                        $this->_setFlashMessage('', 'alert', $errors);
                    }
                } else {
                    $this->_setFlashMessage('Invalid password. Please try again.', 'alert');
                }
            }
            $this->request->data('User.name', $fb_user['name']);
            $this->request->data('User.email_addr', $fb_user['email']);
            $this->set('profile_image', 'http://graph.facebook.com/'.$fb_user['id'].'/picture?type=normal');
        } else {
            $this->redirect(array('action' => 'login'));
        }
        $this->layout = 'login';
    }

    public function logout()
    {
        $this->_deleteSessionUser();
        $this->Cookie->delete('keep_me_logged_in');
        $this->redirect(array('action' => 'login'));
    }

    public function follow($user_id = null)
    {
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id,
                'User.enabled' => true,
            ),
            'recursive' => -1,
        ));

        if ($user) {
            $follower = $this->_getSessionUser();

            if ($user['User']['id'] != $follower['User']['id']) {
                $follow = $this->Follow->find('count', array(
                    'conditions' => array(
                        'Follow.user_id' => $user['User']['id'],
                        'Follow.follower_id' => $follower['User']['id'],
                    ),
                ));
                if (!$follow) {
                    $follow = array(
                        'user_id' => $user['User']['id'],
                        'follower_id' => $follower['User']['id'],
                        'create_ts' => date('Y-m-d H:i:s', time()),
                    );

                    $this->Follow->create();
                    if ($this->Follow->save($follow)) {
                        $this->_setFlashMessage('You are now following this user.', 'success');
                    } else {
                        $this->_setFlashMessage('You are not able to follow this user.', 'alert');
                    }
                } else {
                    $this->_setFlashMessage('You are already following this user.', 'alert');
                }
            } else {
                $this->_setFlashMessage('You cannot follow yourself.', 'alert');
            }
        } else {
            $this->_setFlashMessage('Invalid user.', 'alert');
        }

        $this->redirect($this->request->referer());
    }

    public function unfollow($user_id = null)
    {
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id,
                'User.enabled' => true,
            ),
            'recursive' => -1,
        ));

        if ($user) {
            $follower = $this->_getSessionUser();

            if ($user['User']['id'] != $follower['User']['id']) {
                $follow = $this->Follow->find('first', array(
                    'conditions' => array(
                        'Follow.user_id' => $user['User']['id'],
                        'Follow.follower_id' => $follower['User']['id'],
                    ),
                    'recursive' => -1,
                ));
                if ($follow) {
                    if ($this->Follow->delete($follow['Follow']['id'], false)) {
                        $this->_setFlashMessage('You are no longer following this user.', 'success');
                    } else {
                        $this->_setFlashMessage('You are not able to unfollow this user.', 'alert');
                    }
                } else {
                    $this->_setFlashMessage('You were not following this user.', 'alert');
                }
            } else {
                $this->_setFlashMessage('You cannot unfollow yourself.', 'alert');
            }
        } else {
            $this->_setFlashMessage('Invalid user.', 'alert');
        }

        $this->redirect($this->request->referer());
    }

    public function people()
    {
        $users = $this->User->find('all', array(
            'conditions' => array(
                'User.facebook_id <>' => Configure::read('Admin.facebook_id'),
                'User.enabled' => true,
            ),
            'order' => array('User.created' => 'DESC'),
        ));
        $this->set('users', $users);
    }

    public function following()
    {
        $user = $this->_getSessionUser();
    }

    public function profile()
    {
        $user = $this->_getSessionUser();

        if ($this->request->isPost()) {
            $this->request->data('User.id', $user['User']['id']);
            $this->User->set($this->request->data);
            if ($this->User->validates(array('fieldList' => array('first_name', 'last_name', 'email_addr')))) {
                if ($this->User->save($this->request->data, false)) {
                    $this->_setFlashMessage('Profile update successful.', 'success');
                    $user = $this->User->find('first', array(
                        'conditions' => array('User.id' => $user['User']['id']),
                    ));
                    $this->_setSessionUser($user);
                }
            } else {
                $errors = $this->User->validationErrors;
                $this->_setFlashMessage('', 'alert', $errors);
            }
        }

        $this->request->data = $user;
        $this->set('user', $user);
    }

    public function password()
    {
        $user = $this->_getSessionUser();

        if ($this->request->isPost()) {
            $this->request->data('User.id', $user['User']['id']);

            if (!empty($this->request->data['User']['old_password'])) {
                $password = crypt($this->request->data['User']['old_password'], self::BLOWFISH_PRE.$user['User']['salt'].self::BLOWFISH_END);
                if ($password === $user['User']['password']) {
                    if ($this->request->data['User']['password'] === $this->request->data['User']['confirm']) {
                        $this->User->set($this->request->data);
                        if ($this->User->validates(array('fieldList' => array('password')))) {
                            // Encrypt password
                            $salt = $this->_generateSalt();
                            $password = crypt($this->request->data['User']['password'], self::BLOWFISH_PRE.$salt.self::BLOWFISH_END);
                            $this->request->data('User.password', $password);
                            $this->request->data('User.salt', $salt);

                            if ($this->User->save($this->request->data, false)) {
                                $this->_setFlashMessage('Password update successful.', 'success');
                                $user = $this->User->find('first', array(
                                    'conditions' => array('User.id' => $user['User']['id']),
                                ));
                                $this->_setSessionUser($user);
                                $this->redirect(array('action' => 'password'));
                            }
                        } else {
                            $errors = $this->User->validationErrors;
                            $this->_setFlashMessage('', 'alert', $errors);
                        }
                    } else {
                        $this->_setFlashMessage('New password and confirmation do not match.', 'alert');
                    }
                } else {
                    $this->_setFlashMessage('Old password is incorrect.', 'alert');
                }
            } else {
                $this->_setFlashMessage('Old password is invalid.', 'alert');
            }
        }

        $this->set('user', $user);
    }

    protected function _generateSalt()
    {
        $allowed_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
        $chars_length = 63;
        $salt_length = 21;

        $mysql_date = date('Y-m-d');
        $salt = '';

        for ($i = 0; $i < $salt_length; ++$i) {
            $salt .= $allowed_chars[mt_rand(0, $chars_length)];
        }

        return $salt;
    }

    const BLOWFISH_PRE = '$2a$05$';
    const BLOWFISH_END = '$';
}
