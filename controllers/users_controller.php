<?php
class UsersController extends AppController {
	
	public $uses = array('User', 'Product');
	
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('dashboard', 'signup', 'checkUsername');
		if($this->action == 'login') {
			$this->Auth->autoRedirect = false;
		}
	}
	
	public function dashboard() {
		$title_for_layout = 'Consumer Love';
		
		if($this->Auth->user()) {
			$inventory = Inventory::get();
			
			if(!empty($inventory)) {
				$Feed = ClassRegistry::init('Feed');
				$feeds = $Feed->getFeed(array_keys($inventory));
			}
			$this->set(compact('title_for_layout', 'feeds'));
			
			$top5Products =  $this->Product->topByCategoryId(5);
			$top5Category = $this->Product->Category->findById(5);
			$categories = $this->Product->Category->getAllThreaded(true);
			$this->set(compact('top5Products', 'top5Category', 'categories'));
			
		} else {
			$this->set('disableSidebar', true);
			$this->set(compact('title_for_layout'));
			$this->render('welcome');
		}
	}
	
	public function signup() {
		if($this->Auth->user()) {
			$this->Session->setFlash('You are already registered and logged in!');
			$this->redirect('/');
		}
		
		if(!empty($this->data)) {
			$user = $this->User->register($this->data);
			if($user !== false) {
				$this->set('user', $user);
				$this->Session->setFlash('Your account has been created, please login below.');
				$this->redirect(array('action'=> 'login'));
			} else {
				unset($this->data[$this->modelClass]['password']);
				unset($this->data[$this->modelClass]['password_confirm']);
				$this->Session->setFlash('Your account could not be created, please correct the errors below.', $this->Auth->flashElement, array(), 'auth');
			}
		}
		
		//$this->layout = 'feature';
		$this->set('title_for_layout', 'Consumer Love / Sign up');
	}
	
	public function login() {
		if(!empty($this->data)) {
			// Try to login with Email
			if(
				!$this->Auth->user()
				&& !empty($this->Auth->data['User']['username'])
				&& !empty($this->Auth->data['User']['password'])
			) {
				$user = $this->User->find('first', array(
					'conditions' => array(
						'User.email' => $this->Auth->data['User']['username'],
						'User.password' => $this->Auth->data['User']['password']
					),
					'recursive' => -1
				));
				
				if(!empty($user) && $this->Auth->login($user)) {
					// They logged in, so kill the flash message
					$this->Session->delete('Message.auth');
				} else {
					$this->Session->setFlash($this->Auth->loginError, $this->Auth->flashElement, array(), 'auth');
				}
			}
			
			// If they logged in, either through auth or above email check
			if($this->Auth->user()) {
				// Update last login, set flash message.
				$this->User->id = $this->Auth->user('id');
				$this->User->saveField('last_login', date('Y-m-d H:i:s'));
				$this->Session->setFlash('You have successfully logged in.');
				
				// Remember User
				if(!empty($this->data['User']['remember'])) {
					$this->User->recursive = -1;
					$user = $this->User->read(array('username', 'password'));
					
					$this->Cookie->write('User', array_intersect_key(
						$user[$this->Auth->userModel],
						array('username' => null, 'password' => null)
					), true, '1 year');
				} elseif($this->Cookie->read('User') != null) {
					$this->Cookie->delete('User');
				}
				if($this->data['User']['return_to']) {
					$this->redirect($this->data['User']['return_to']);
				}
				$this->redirect($this->referer());
			}
		} else {
			
			// Set return_to to last page
			$returnTo = $this->Auth->redirect();
			if($returnTo == $this->here) {
				$returnTo = false;
			}
			
			$this->set(compact('return_to'));
			
			$this->set(compact('returnTo'));
			
			if($this->Auth->user()) {
				$this->Session->setFlash('You are already registered and logged in!');
				$this->redirect($this->Auth->redirect());
			}
		}
		
		$this->set('title_for_layout', 'Consumer Love / Login');
	}
	
	// Page for people to merge their accounts and setup username
	public function connect() {
		if(isset($this->data)) {
			$this->User->id = $this->userData['User']['id'];
			if($this->User->save($this->data)) {
				$this->Session->setFlash('Thanks for setting up your account.');
				$this->redirect('/');
			}
		}
		$title_for_layout = 'Your Account';
		
		$this->set(compact('title_for_layout'));
	}
	
	public function view($slug = null) {
		$user = $this->User->find('first', array(
			'conditions' => array(
				'User.slug' => $slug
			),
			'contain' => array(false)
		));
		if(empty($user)) {
			$this->cakeError('error404');
		}
		
		$inventory = $this->userData['User']['id'] == $user['User']['id'] ? Inventory::get() : $this->User->Inventory->getUserInventory($user['User']['id']);
		
		$title_for_layout = $user['User']['username'];
		$this->set(compact('title_for_layout', 'user'));
	}
	
	public function logout() {
		if($this->Cookie->read('User') != null) {
			$this->Cookie->delete('User');
		}
		$this->Auth->logout();
		$this->redirect('/');
	}
	
	/* Ajax Actions */
	public function checkUsername() {
		if($this->isApiCall()) {
			$this->set('status', $this->User->checkUsernameAvailability($this->params['url']['username']));
		} else {
			$this->cakeError('error404');
		}
	}
	
	/* Admin Actions */
	public function admin_index() {
		$this->set('users', $this->paginate('User'));
	}
}