<?php

class UsersController extends AppController {

    public $paginate = array(
        'Inventory' => array(
            'order' => 'Product.name'
        )
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('dashboard', 'signup', 'checkUsername', 'view');
    }

    public function dashboard() {
        $title_for_layout = __('Consumer Love');

        if ($this->Auth->user()) {
            if (!empty($this->userInventory)) {
                $this->set('latestInventory', array_slice($this->userInventory, 0, 15));

                $News = ClassRegistry::init('News');
                $this->set('news', $News->timeline(array_keys($this->userInventory)));
            }


            $top5Products = $this->Product->topByCategoryId(5);
            $top5Category = $this->Product->Category->findById(5);
            $categories = $this->Product->Category->getAllThreaded(true);
            $this->set(compact('title_for_layout', 'top5Products', 'top5Category', 'categories', 'news'));
        } else {
            $products = $this->Product->find('active', array(
                'conditions' => array(),
                'recursive' => -1,
                'order' => 'RAND()',
                'limit' => 14
                    ));

            $disableSidebar = true;
            $this->set(compact('products', 'news', 'disableSidebar', 'title_for_layout'));
            $this->render('welcome');
        }
    }

    public function signup() {
        if ($this->Auth->user()) {
            $this->Session->setFlash('You are already registered and logged in!');
            $this->redirect('/');
        }

        if (!empty($this->data)) {
            $user = $this->User->register($this->data);
            if ($user !== false) {
                $this->set('user', $user);
                $this->Session->setFlash('Your account has been created, please login below.');
                $this->redirect(array('action' => 'login'));
            } else {
                $this->Session->setFlash('Your account could not be created, please correct the errors below.', $this->Auth->flashElement, array(), 'auth');
            }
        }

        //$this->layout = 'feature';
        $this->set('title_for_layout', 'Consumer Love / Sign up');
    }

    public function login() {
        // 2.0 Auth login
        if ($this->request->is('post')) {
            // Try to login
            $user = $this->User->login(
                    $this->request->data['User']['username'], AuthComponent::password($this->request->data['User']['password'])
            );

            if (!empty($user)) {
                $this->Auth->login($user['User']);

                // Update last login
                $this->User->id = $user['User']['id'];
                $this->User->saveField('last_login', date('Y-m-d H:i:s'));
                $this->Session->setFlash('You have successfully logged in.');

                if (!empty($this->request->data['User']['remember'])) {
                    $this->Cookie->write('User', array_intersect_key(
                                    $user['User'], array('username' => null, 'password' => null)
                            ), true, '1 year');
                } elseif ($this->Cookie->read('User') != null) {
                    // Delete cookie if they didnt tick a box
                    $this->Cookie->delete('User');
                }

                return $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash($this->Auth->loginError, $this->Auth->flashElement, array(), 'auth');
            }
        }

        if ($this->Auth->user()) {
            $this->Session->setFlash('You are already registered and logged in!');
            $this->redirect($this->Auth->redirect());
        }

        $this->set('title_for_layout', 'Consumer Love / Login');
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
        $title_for_layout = 'Your Account';

        $this->set(compact('title_for_layout'));
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

        $inventory = $this->User->Inventory->get($user['User']['id'], 10);

        $title_for_layout = $user['User']['username'] . __(' on Consumer Love');
        $this->set(compact('title_for_layout', 'user', 'inventory', 'latestLove'));
    }

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

        $title_for_layout = 'Update Your Profile';

        $this->set(compact('title_for_layout'));
    }

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
    }

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

    public function admin_index() {
        $this->set('users', $this->paginate('User'));
    }

}