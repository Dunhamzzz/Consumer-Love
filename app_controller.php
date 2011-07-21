<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller {
	public $components = array(
		'Auth' => array(
			'authorize' => 'controller',
			'logoutRedirect' => '/',
			'autoRedirect' => false,
			'loginAction' => array('controller' => 'users', 'action' => 'login', 'admin' => false),
			'loginError' => 'Invalid login details',
			'authError' => 'You need to be logged in to access this location.',
			'fields' => array(
				'username' => 'username',
				'password' => 'password'
			)
		),
		'DebugKit.Toolbar',
		'Cookie',
		'Session',
		'RequestHandler'
	);
	
	public $helpers = array(
		'Js' => array('Jquery'),
		'Utils.Gravatar' => array('default' => 'mm'),
		'Session',
		'Text',
		'Time',
		'Love',
		'Link',
		'Button'
	);
	
	public function beforeFilter() {
		if($this->Auth->getModel()->hasField('active')) {
	        $this->Auth->userScope = array('active' => 1);
		}
		
		// $this->layout = 'new';
		
		$userData = $this->Auth->user();
		if(!empty($userData)) {
			$this->userData = $userData;
			Configure::write('User', $userData[$this->Auth->getModel()->alias]);
			
			// Allow stuff if admin
			if($this->Auth->user('is_admin')) {
        		$this->Auth->allow('*');
        	}
        	
        	// Get Inventory
        	$userInventory = $this->Auth->getModel()->Inventory->getUserInventory(User::get('id'));
        	Configure::write('Inventory', $userInventory);
        	
        	
        	// Update Last Activity
        	$this->Auth->getModel()->updateLastActivity();
        	
        	// Set view vars.
        	$this->set(compact('userData', 'userInventory'));
        	
        	
		} else { // Check if they have a cookie and try to log them in
			$userData = $this->Cookie->read('User');
			if(!empty($userData)) {
				$userData = $this->Auth->getModel()->find('first', array(
					'conditions' => array(
						$this->Auth->fields['username'] => $userData[$this->Auth->fields['username']],
						$this->Auth->fields['password'] => $userData[$this->Auth->fields['password']],
					),
					'recursive' => -1
				));
				
				// Log them in!
				if(!empty($userData) && $this->Auth->login($userData)) {
					$this->redirect($this->Auth->redirect());
				}
			}
		}
        
        if($this->isApiCall()) {
			Configure::write('debug', 0);
		}
	}
	
	public function beforeRender() {
		$this->set('pageWidgets', array());
	}
	
	public function isAuthorized() {
		return true;
	}
	
	public function isApiCall() {
    	return $this->RequestHandler->isAjax()
        || $this->RequestHandler->isXml()
        || $this->RequestHandler->prefers('json');
	}
	
	/* Facebook Plugin Callbacks */
	public function beforeFacebookSave(){
		// Look for existing user with email
		$user = $this->Auth->getModel()->find('first', array(
			'conditions' => array('email' => $this->Connect->user('email')),
			'contain' => false,
			'fields' => array('id')
		));
		
		if($user) {
			//$this->Connect->authUser['User']['id'] = $user['User']['id'];
			//unset($this->Connect->authUser['User']['password']);
		}
		
		$this->Connect->authUser['User']['email'] = $this->Connect->user('email');
	
	    return true; //Must return true or will not save.
	}
	
	public function afterFacebookLogin(){
	    //Logic to happen after successful facebook login.
	    $this->redirect($this->here);
	}
}