<?php

class User extends AppModel {

    public $displayField = 'username';
    public $hasMany = array(
        'Inventory',
        'Thread',
        'Post',
        'ProductImage',
        'News'
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
            ),
            'username_alpha' => array(
                'rule' => 'alphaNumeric',
                'message' => 'Your username may only contain letters and numbers.',
            ),
            'unique_username' => array(
                'rule' => array('isUnique', 'username'),
                'message' => 'Unfortunately this username has already been taken.',
            ),
            'username_min' => array(
                'rule' => array('minLength', 3),
                'message' => 'Your username must be at least 3 characters long.',
            )
        ),
        'email' => array(
            'email_notEmpty' => array(
                'required' => true,
                'rule' => 'notEmpty',
                'message' => 'Please enter an email address.',
                'on' => 'create'
            ),
            'email_isValid' => array(
                'rule' => array('email', true),
                'message' => 'Please enter a valid email address.',
            ),
            'email_isUnique' => array(
                'rule' => array('isUnique', 'email'),
                'message' => 'This email is already in use.',
            ),
        ),
        'password' => array(
            'password_required' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter a valid password.',
                'on' => 'create',
                'last' => true
            ),
            'password_confirmed' => array(
                'rule' => array('comparePasswords', array('password_confirm')),
                'message' => 'Passwords do not match.'
            )
        )
    );

    /**
     * A list of fields that can be updated by the user
     * @var type array
     */
    protected $_whiteListFields = array(
        'real_name', 'bio', 'dob', 'website', 'email', 'dob', 'location', 'private_inventory'
    );

    public function beforeSave($options = array()) {
        if (!$this->id) { // We are creating
            $this->data['User']['key'] = String::uuid();
        }

        if (isset($this->data['User']['password'])) {
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
        if ($this->validates()) {
            $this->create();
            // Save, do not re-validate
            return $this->save($postData, false);
        }
        return false;
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

        if (!$this->userData) {
            return false;
        }
        $this->id = $this->userData['id'];

        $data = array(
            'last_activity' => date('Y-m-d H:i:s', time()),
            'modified' => false
        );

        $this->save($data, array('validate' => false));
    }

    /**
     * Saves profile data.
     * @param type $data User row
     */
    public function updateProfile($data) {
        $this->read(null, $data['id']);

        $this->set($data);

        if ($this->validates()) {
            return $this->save($data, false, $this->_whiteListFields);
        }
        return false;
    }

    /**
     * Increments the profile_hits field if user is not current
     */
    public function profileHit($userId) {
        if (AuthComponent::user('id') && $userId == AuthComponent::user('id')) {
            return false;
        }

        $this->updateAll(array('User.profile_hits' => 'User.profile_hits + 1'), array('User.id' => $userId));
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

    // Gets latest posts by user
    public function getLatestPosts($userId, $limit = 10) {
        return $this->Post->find('all', array(
                    'conditions' => array(
                        'Post.user_id' => $userId
                    ),
                    'contain' => array('Thread' => array('Product')),
                    'limit' => $limit
                ));
    }

}