<?php

class UsersController extends AppController {

    public $paginate = array(
        'Inventory' => array(
            'order' => 'Product.name',
            'limit' => 10
        )
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('dashboard', 'signup', 'checkUsername', 'view', 'inventory');
    }
    
    /**
     * Inifinite scroll pagination fix. 
     */
    public function afterFilter() {
        if($this->request->is('ajax')) {
            $pageCount = $this->params['paging']['Inventory']['pageCount'];
            if ((!empty($this->params['named']['page'])) && ($this->params['named']['page'] > $pageCount)) {
                throw NotFoundException(__('Page not found.'));
            }
        }
    }

    public function dashboard() {
        $this->set('title_for_layout', __('Consumer Love'));

        if ($this->Auth->user()) {
            if (!empty($this->userInventory)) {
                $this->set('latestInventory', array_slice($this->userInventory, 0, 15));

                $News = ClassRegistry::init('News');
                $this->set('news', $News->timeline(array_keys($this->userInventory)));
            }


            $this->set('top5Products', $this->Product->topByCategoryId(5));
            $this->set('top5Category', $this->Product->Category->findById(5));
            $this->set('categories', $this->Product->Category->getAllThreaded(true));
        } else {
            $products = $this->Product->find('active', array(
                'conditions' => array(),
                'recursive' => -1,
                'order' => 'RAND()',
                'limit' => 14
                    ));

            $this->set('disableSidebar', true);
            $this->set(compact('products', 'title_for_layout'));
            $this->render('welcome');
        }
    }

    /**
     * User Signup action
     *
     * URL: /signup/
     */
    public function signup() {
        if ($this->Auth->user()) {
            $this->Session->setFlash('You are already registered and logged in!');
            $this->redirect('/');
        }

        if($this->request->is('post')) {
            
            if($this->User->register($this->request->data)) {
                $this->Session->setFlash('Your account has been created, please login below.');
                $this->redirect(array('action' => 'login'));
            } else {
                $this->Session->setFlash('Your account could not be created, please correct the errors below.');
            }
            
        } 
        
        $this->set('title_for_layout', 'Consumer Love / Sign up');
    }

    /**
     * User Login action
     *
     * URL: /login
     */
    public function login() {
        // 2.0 Auth login
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {

                $user = $this->Auth->user();
                
                // Update last login
                $this->User->id = $user['id'];
                $this->User->saveField('last_login', date('Y-m-d H:i:s'));
                $this->Session->setFlash('You have successfully logged in.');

                if (!empty($this->request->data['User']['remember'])) {
                    $cookieData = array_intersect_key(
                                    $this->request->data['User'], array('username' => null, 'password' => null)
                            );
                    $this->Cookie->write('User', $cookieData, true, '1 year');
                } elseif ($this->Cookie->read('User') != null) {
                    // Delete cookie if they didnt tick a box
                    $this->Cookie->delete('User');
                }

                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(__('Unable to login, please check your credentials.'));
            }
        }

        if ($this->Auth->user()) {
            $this->Session->setFlash('You are already registered and logged in!');
            $this->redirect($this->Auth->redirect());
        }

        $this->set('title_for_layout', __('Consumer Love / Login'));
    }

    // Page for people to merge their accounts and setup username
    public function connect() {
        if (isset($this->data)) {
            $this->User->id = $this->userData['User']['id'];
            if ($this->User->save($this->data)) {
                $this->Session->setFlash('Thanks for setting up your account.');
                $this->redirect('/');
            }
        }
        $this->set('title_for_layout', __('Your Account'));
    }

    /**
     * View a users profile.
     * URL: /profiles/:userSlug
     * 
     * @param string $userSlug 
     */
    public function view($userSlug = null) {

        $user = $this->User->getBySlug($userSlug);
        if (empty($user)) {
            throw new NotFoundException();
        }

        // Increment profile hits.
        $this->User->profileHit($user['User']['id']);

        // Get Inventory
        $this->set('inventory', $this->User->Inventory->get($user['User']['id'], 8));

        // Get Latest Posts
        $this->set('latestPosts', $this->User->Post->getLatest(5, $user['User']['id']));

        $this->set('title_for_layout', __('%s on Consumer Love', $user['User']['username']));

        $this->set(compact('user', 'latestLove'));
    }

    /**
     * Settings page where users can edit their profile
     *
     * URL: /users/settings
     */
    public function settings() {
        if ($this->request->is('put')) {
            $this->request->data['id'] = AuthComponent::user('id');

            if ($this->User->updateProfile($this->request->data)) {
                $this->Session->setFlash('Profile settings updated.');
            } else {
                $this->invalidFields();
                die('wht');
            }
        } else {
            $this->request->data = $this->User->find('first', array(
                'conditions' => array('id' => AuthComponent::user('id')),
                'contain' => false
                    ));
        }

        $this->set('title_for_layout', __('Update Your Profile'));
    }

    /**
     * Displays list of a users inventory
     * @param string $userSlug
     * @throws NotFoundException 
     */
    public function inventory($userSlug = null) {
        $user = $this->User->getBySlug($userSlug);

        if (empty($user)) {
            throw new NotFoundException();
        }

        if ($user['User']['private_inventory'] != 1) {
            $products = $this->paginate($this->User->Inventory, array('Inventory.user_id' => $user['User']['id'])); //$this->User->Inventory->get($user['User']['id'], 10);
        } else {
            $this->set('privateInventory', true);
        }

        $title_for_layout = $user['User']['username'] . '/Inventory';
        $this->set(compact('user', 'products', 'title_for_layout'));
        
        // If an ajax request, jsut load what we need.
        
    }

    /**
     * Logout action. Will direct user to homepage. 
     */
    public function logout() {
        if ($this->Cookie->read('User') != null) {
            $this->Cookie->delete('User');
        }
        $this->Auth->logout();
        $this->redirect('/');
    }

    /* Ajax Actions */

    public function checkUsername() {
        if ($this->request->is('ajax')) {
            $this->set('status', $this->User->checkUsernameAvailability($this->params['url']['username']));
        } else {
            throw new MethodNotAllowedException();
        }
    }

    /* Admin Actions */

    /*
     * User list for admin
     */
    public function admin_index() {
        $this->set('users', $this->paginate('User'));
    }

}