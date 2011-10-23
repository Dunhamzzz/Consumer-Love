<?php
class User extends AppModel {
	public $displayField = 'username';
	
	public $hasMany = array(
		'Inventory',
		'Thread',
		'Post',
		'Product'
	);
	
	public $actsAs = array(
		'Utils.Sluggable' => array(
			'label' => 'username',
			'method' => 'multibyteSlug',
			'separator' => '-'
		)
	);
	
	public $validate = array(
		'username' => array(
			'username_required' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'allowedEmpty' => false,
				'on' => 'create',
				'message' => 'Please enter a username.',
				'last' => true
			),
			'username_alpha' => array(
				'rule' => 'alphaNumeric',
				'message' => 'Your username may only contain letters and numbers.',
				'last' => true
			),
			'unique_username' => array(
				'rule' => array('isUnique', 'username'),
				'message' => 'Unfortunately this username has already been taken.',
				'last' => true
			),
			'username_min' => array(
				'rule' => array('minLength', 3),
				'message' => 'Your username must be at least 3 characters long.',
				'last' => true
			)
		),
		'email' => array(
			'email_notEmpty' => array(
				'required' => true,
				'rule' => 'notEmpty',
				'message' => 'Please enter an email address.',
				'last' => true,
				'on' => 'create'
			),
			'email_isValid' => array(
				'rule' => array('email', true),
				'message' => 'Please enter a valid email address.',
				'last' => true
			),
			'email_isUnique' => array(
				'rule' => array('isUnique','email'),
				'message' => 'This email is already in use.',
				'last' => true
			),
		),
		'password' => array(
            'password_required' => array(
            	'rule' => array('emptyPassword', array('password_confirm')),
          	 	'message' => 'Please enter a valid password.',
            	'last' => true
        	),
        	'password_confirmed' => array(
	            'rule' => array('comparePasswords', array('password_confirm')),
	            'message' => 'Passwords do not match.'
        	)
		)
	);
	
	public function beforeSave($options = array()) {
		if(!$this->id) { // We are creating
			$this->data['User']['key'] = String::uuid();
		}
		
		if(isset($this->data['User']['password'])) {
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		}
		return true;
	}
	
	// Checks a login and returns a user
	public function login($usernameOrEmail, $password) {
		return $this->find('first', array(
			'conditions' => array(
				'OR' => array(
					'User.email' => $usernameOrEmail,
					'User.username' => $usernameOrEmail
				),
				'User.password' => $password
			),
			'recursive' => -1
		));
	}
	
	public function getBySlug($slug, $contain = false) {
		return $this->find('first', array(
				'conditions' => array(
				'User.slug' => $slug
			),
			'contain' => array($contain)
		));
	}
	
	public function register($postData = array()) {
		
		$postData[$this->alias]['active'] = 1;
		
		$this->set($postData);
		if($this->validates()) {
			$this->create();
			// Save, do not re-validate
			return $this->save($postData, false);
		}
		return false;
	}
	
	// Check password is empty http://bin.cakephp.org/saved/42156
	public function emptyPassword($value = array(), $options = array(), $rule = array()) {
	    if ($this->compare($value, Security::hash('', null, true))) {
	        $this->invalidate($options[0], $rule['message']);
	        return false;
	    }
	    return true;
	}
	
	// Check passwords match
	public function comparePasswords($value = array(), $options = array(), $rule = array()) {
	    if (
	    	isset($this->data[$this->alias][$options[0]]) &&
	    	!$this->compare($value, $this->data[$this->alias][$options[0]])
	    ) {
	        $this->invalidate($options[0], $rule['message']);
	        return false;
	    }
	    return true;
	}
	
	public function updateLastActivity() {
		$this->userData = AuthComponent::user();
		
		if(!$this->userData) {
			return false;
		}
		$this->id = $this->userData['id'];
		
		$data = array(
			'last_activity' => date('Y-m-d H:i:s', time()),
			'modified' => false
		);
		
		$this->save($data, array('validate' => false));
	}
	
	public function increaseHumanProven() {
		$this->updateAll(array('User.human_proven_count' => 'User.human_proven_count+1'), array('User.id' => $this->userData['id']));
	}
	
	// Returns 0/1 depending on username availability
	public function checkUsernameAvailability($username) {
		// Check if it validates
		$data = array('User' => array('username' => $username));
		
		$this->set($data);
		return $this->validates(array('fieldList' => array('username')));
	}
	
	public static function get($field = null) {
		$user = Configure::read('User');
		if(empty($user) || (!empty($field) && !array_key_exists($field, $user))) {
			return false;
		}
		
		return !empty($field) ? $user[$field] : $user;
	}
	
	// Connects a username-less user to their existing User row on their email address
	public function connectFacebook() {
		
	}
}