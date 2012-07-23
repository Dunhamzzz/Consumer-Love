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
                'Authenticate.Cookie' => array(
                    'fields' => array(
                        'username' => 'username',
                        'password' => 'password'
                    ),
                    'userModel' => 'User',
                    'scope' => array('User.active' => 1)
                ),
                'Authenticate.MultiColumn' => array(
                    'fields' => array(
                        'username' => 'username',
                        'password' => 'password'
                    ),
                    'columns' => array('username', 'email'),
                    'userModel' => 'User',
                    'scope' => array('User.active' => 1),
                )
            ),
            'loginAction' => array(
                'controller' => 'users',
                'action' => 'login',
                'admin' => false
            ),
            'authorize' => array('Controller')
        ),
        'RequestHandler',
        'DebugKit.Toolbar',
        'Cookie',
        'Session'
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

    /**
     * Stores user data for each request
     */
    public $userInventory;
    
    /**
     * Actions a logged-in user is allowed to access.
     * @var array 
     */
    public $allowedActions;

    public function beforeFilter() {

        // Every page needs products model
        $this->loadModel('Product');

        $userData = AuthComponent::user();
        if ($userData) {

            // Allow stuff if admin
            if ($this->Auth->user('is_admin')) {
                $this->Auth->allow('*');
            }

            // Load User model
            $this->loadModel('User');

            // Update Last Activity
            $this->User->updateLastActivity();

            // Grab users Inventory
            $this->loadModel('Inventory');
            $this->userInventory = $this->Inventory->get($this->Auth->user('id'));
            $this->set('inventory', $this->userInventory);

            // Set view vars.
            $this->set(compact('userData'));
        } else {
            // Attempt Cookie Login, but only if not on login page as it prevents login logic from running.
            if (!$this->request->is('post')
                && !($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'login')
            ) {
                
                $user = $this->Auth->login();
                if ($user) {
                    $this->redirect($this->here);
                }
            }
        }

        if ($this->request->is('ajax')) {
            //Configure::write('debug', 0);
        }

    }

    public function beforeRender() {
        $this->set('pageWidgets', array());
    }

    public function isAuthorized($user) {
        
        if(in_array($this->action, $this->allowedActions)) {
            return true;
        }
        
        // Admin can access every action
        if ($user['admin'] == '1') {
            return true;
        }

        // Default deny
        return false;
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