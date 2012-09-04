<?php

class ThreadsController extends AppController {

    public $paginate = array(
        'Thread' => array(
            'limit' => 20,
            'order' => 'Thread.last_post_date DESC'
        ),
        'Post' => array(
            'limit' => 10,
            'order' => 'Post.created ASC'
        ),
        'Product' => array(
            'limit' => 20,
            'order' => 'Product.name ASC',
            'contain' => array('Category')
        )
    );
    public $allowedActions = array(
        'create'
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('all', 'view', 'forums'));
    }

    public function isAuthorized($user) {
        // The owner of a post can edit and delete it
        if (in_array($this->action, array('delete'))) {

            $threadId = $this->request->params['pass'][0];
            if ($this->Thread->isOwnedBy($threadId, $user['id'])) {
                return true;
            }
        }

        return parent::isAuthorized($user);
    }

    public function all($productSlug) {

        $product = $this->Thread->Product->getBySlug($productSlug);
        $this->set('threads', $this->paginate('Thread', array('product_id' => $product['Product']['id'])));

        $this->set('title_for_layout', __('%s Forum', $product['Product']['name']));
        $this->set(compact('product'));
    }

    public function create($productId = null) {
        // Check Product
        $this->Thread->Product->id = $productId ? $productId : $this->request->data['Thread']['product_id'];

        if (!$this->Thread->Product->exists()) {
            throw new NotFoundException(__('Invalid Product.'));
        }

        $this->Thread->Product->contain('Category'); // For meta widget
        $product = $this->Thread->Product->read();

        if (!empty($this->request->data)) {
            $this->request->data['Thread']['user_id'] = $this->Auth->user('id');
            $this->request->data['Thread']['user_ip'] = $this->RequestHandler->getClientIp();

            if ($this->Thread->add($this->request->data)) {
                $this->Session->setFlash(__('Your thread has been saved successfully.'));
                //$this->redirect(array('controller' => 'products', 'action' => 'view', 'productSlug' => $product['Product']['slug']));
            } else {
                $this->Session->setFlash(__('Unable to create new thread, please correct the errors below.'));
            }
        }

        $this->set('title_for_layout', __('New Thread'));
        $this->set('product', $product);
    }

    public function view($productSlug, $threadSlug = null) {
        // Get product, it should always exist thanks to our route
        $product = $this->Thread->Product->getBySlug($productSlug);

        if (empty($product)) {
            throw new NotFoundException(__('Invalid Product.'));
        }

        $thread = $this->Thread->getBySlug($threadSlug, $product['Product']['id']);

        if (empty($thread)) {
            throw new NotFoundException(__('Invalid Thread'));
        }

        //@todo use 2.0 paginator
        $this->set('posts', $this->paginate('Post', array('thread_id' => $thread['Thread']['id'])));

        $this->set('title_for_layout', $thread['Thread']['title']);
        $this->set(compact('product', 'thread'));
    }

    /**
     * Displays a list of forums to user, otherwise, most popular forums
     * URL: /forums
     */
    public function forums() {

        if ($this->Auth->user()) {
            // Get list of products from inventory
            $this->set('forums', $this->paginate('Product', array(
                        'Product.id' => array_keys($this->userInventory),
                    )));

            $this->set('title_for_layout', __('Your Consumer Love Forums'));
        } else {
            $this->paginate['Product']['order'] = 'Name';
            $this->set('forums', $this->paginate('Product'));

            // Get most popular forums
            $this->set('title_for_layout', __('Consumer Love Forums'));
        }
    }

    public function delete($threadId = null) {

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        // Get Product so we know where to redirect back to
        $thread = $this->Thread->getForReply($threadId);

        if (!$thread) {
            throw new NotFoundException(__('No thread found.'));
        }

        if ($this->Thread->delete($threadId)) {
            $this->Session->setFlash(__('Thread deleted.'));
            $this->redirect('/' . $thread['Product']['slug']);
        }

        $this->Session->setFlash(__('Thread not deleted!'));
        $this->redirect('/' . $thread['Product']['slug']);
    }

    /* Admin Actions */

    public function admin_index() {

        $this->paginate['order'] = 'created DESC';
        $this->set('threads', $this->paginate());
        $this->set('title_for_layout', __('Forum Admin'));
    }

    public function admin_actions() {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        if (empty($this->request->data['threadId'])) {
            throw new DomainException(__('No threads selected.'));
        }

        if ($this->request->data['action'] == 'Delete') {

            $this->Thread->deleteAll(array('Thread.id' => $this->request->data('threadId')));
            $this->Session->setFlash(__('Selected thread(s) deleted.'));
            $this->redirect('/admin/threads/index');
        } else {
            throw new MethodNotAllowedException();
        }
    }

}