<?php

class ThreadsController extends AppController {

    public $paginate = array(
        'Thread' => array(
            'limit' => 25,
            'order' => 'LastPost.created DESC'
        ),
        'Post' => array(
            'limit' => 10,
            'order' => 'Post.created ASC'
        )
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('all', 'view'));
    }

    public function all($productSlug) {
        $product = $this->Thread->Product->getBySlug($productSlug);
        // @todo use 2.0 paginator
        $threads = $this->paginate('Thread', array('product_id' => $product['Product']['id']));

        $title_for_layout = $product['Product']['name'] . ' Forum';
        $this->set(compact('product', 'threads', 'title_for_layout'));
    }

    public function create($productId = null) {
        // Check Product
        $this->Thread->Product->id = $productId ? : $this->request->data['Thread']['product_id'];

        if (!$this->Thread->Product->exists()) {
            throw new NotFoundException(__('Invalid Product.'));
        }

        $this->Thread->Product->contain('Category'); // For meta widget
        $product = $this->Thread->Product->read();

        if (!empty($this->request->data)) {
            $this->request->data['Thread']['user_id'] = $this->userData['id'];
            $this->request->data['Thread']['user_ip'] = $this->RequestHandler->getClientIp();

            // Spam check goes here
            $this->request->data['Thread']['published'] = 1;

            if ($this->Thread->add($this->request->data)) {
                $this->Session->setFlash('Your thread has been saved successfully.');
                $this->redirect(array('controller' => 'products', 'action' => 'view', $product['Product']['slug']));
            } else {
                $this->Session->setFlash('Please correct the errors below.');
            }
        }

        $title_for_layout = 'New Thread';
        $this->set(compact('product', 'title_for_layout'));
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
        $posts = $this->paginate('Post', array('thread_id' => $thread['Thread']['id']));

        $this->set('title_for_layout', $thread['Thread']['title']);
        $this->set(compact('product', 'thread', 'posts'));
    }

    /* Admin Actions */

    public function admin_delete($id) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
    }

}