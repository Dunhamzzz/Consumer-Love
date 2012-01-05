<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * This is a placeholder class.
 * Create the same file in app/app_controller.php
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       Cake.Controller
 * @link http://book.cakephp.org/view/957/The-App-Controller
 */
class AppController extends Controller {

    public $components = array(
        'Auth' => array(
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'User',
                    'userScope' => array('User.active' => 1),
                    'authError' => 'You need to be logged in to access this location.',
                    'loginError' => 'Invalid login details',
                )
            ),
            'loginAction' => array('controller' => 'users', 'action' => 'login', 'admin' => false)
        ),
        'RequestHandler',
        'DebugKit.Toolbar',
        'Cookie',
        'Session',
            //	'Security' // This breaks post edit form and is not so good for ajax.
    );
    public $helpers = array(
        'Html',
        'Text',
        'Form',
        'Js' => array('Jquery'),
        'Utils.Gravatar' => array('default' => 'mm'),
        'Session',
        'Time',
        'Love',
        'Link'
    );
    public $userInventory, $userData;

    public function beforeFilter() {

        // Every page needs products model
        $this->loadModel('Product');

        $userData = AuthComponent::user();
        if (!empty($userData)) {

            $this->userData = $userData;

            // Allow stuff if admin
            if ($this->Auth->user('is_admin')) {
                $this->Auth->allow('*');
            }

            // Load User model
            $this->loadModel($this->Auth->authenticate['Form']['userModel'], $userData['id']);

            // Update Last Activity
            $this->User->updateLastActivity();

            // Grab users Inventory
            $this->loadModel('Inventory');
            $this->userInventory = $this->Inventory->get(AuthComponent::user('id'));
            $this->set('inventory', $this->userInventory);

            // Set view vars.
            $this->set(compact('userData'));
        } else { // Check if they have a cookie and try to log them in
            $userData = $this->Cookie->read('User');
            if (!empty($userData)) {
                // Loader User model
                $this->loadModel($this->Auth->authenticate['Form']['userModel']);

                $userData = $this->User->login(
                        $userData['username'], $userData['password']
                );

                // Log them in and refresh page
                if (!empty($userData) && $this->Auth->login($userData['User'])) {
                    $this->redirect($this->request->here);
                }
            }
        }

        if ($this->request->is('ajax')) {
            //Configure::write('debug', 0);
        }

        // Get Latest Posts
        $this->loadModel('Post');
        $this->Post = new Post();
        $this->set('latestPosts', $this->Post->getLatest());
    }

    public function beforeRender() {
        //$this->set('pageWidgets', array());
    }

    public function isAuthorized() {
        return true;
    }

    /* Facebook Plugin Callbacks */

    public function beforeFacebookSave() {
        // Look for existing user with email
        $user = $this->Auth->getModel()->find('first', array(
            'conditions' => array('email' => $this->Connect->user('email')),
            'contain' => false,
            'fields' => array('id')
                ));

        if ($user) {
            //$this->Connect->authUser['User']['id'] = $user['User']['id'];
            //unset($this->Connect->authUser['User']['password']);
        }

        $this->Connect->authUser['User']['email'] = $this->Connect->user('email');

        return true; //Must return true or will not save.
    }

    public function afterFacebookLogin() {
        //Logic to happen after successful facebook login.
        $this->redirect($this->here);
    }

}