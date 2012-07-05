<?php

class CategoriesController extends AppController {

    public $paginate = array(
        'Product' => array(
            'joins' => array(
                array(
                    'table' => 'categories_products',
                    'alias' => 'CategoryFilter',
                    'type' => 'INNER',
                    'conditions' => array(
                        'CategoryFilter.product_id = Product.id'
                    )
                )
            ),
            'limit' => 10
        )
    );

    public function beforeFilter() {
        $this->Auth->allow('index', 'view');
        parent::beforeFilter();
    }

    public function index() {
        $this->set('categories', $this->Category->getAllThreaded(false));
    }

    public function view($slug) {
        $this->Category->contain(false);
        $category = $this->Category->findBySlug($slug);
        if (!$category) {
            throw new NotFoundException(__('Invalid category'));
        }

        $this->set('category', $category);
        $this->set('path', $this->Category->getPath($category['Category']['id']));

        // Make custom method
        if (isset($this->params['data']['sort'], $this->params['data']['order'])) {
            $this->paginate['Product']['order'] = array($this->params['data']['sort'] => $this->params['data']['order']);
        }

        // Paginate list of products
        $conditions = array_merge(
                array('CategoryFilter.category_id' => $category['Category']['id']), array($this->Category->Product->activeConditions())
        );

        $this->set('products', $this->paginate($this->Category->Product, $conditions));

        $this->set('title_for_layout', $category['Category']['name']);
    }

    /** Admin Actions * */
    public function admin_index() {
        $this->set('categories', $this->Category->getAllThreaded(false));
        $this->set('title_for_layout', 'Manage Categories');
    }

    public function admin_new() {
        if ($this->request->is('post')) {
            if ($this->Category->add($this->request->data)) {
                $this->Session->setFlash($this->request->data['Category']['name'] . ' have been saved.');

                $this->redirect(array(
                    'controller' => 'categories',
                    'action' => 'edit',
                    'admin' => true,
                    $this->Category->id
                ));
            }
        }

        $this->set('title_for_layout', 'Add Category');
        $this->set('parents', array('') + $this->Product->Category->getAllThreaded());
    }

    /**
     * Admin Edit category page.
     * @param int $id 
     */
    public function admin_edit($id = null) {

        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }

        $category = $this->Category->read();
        
        if ($this->request->is('put')) {
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(__('Changes made to %s have been saved.', $this->request->data['Category']['name'] ));
                
                // Refresh page
                $this->redirect(array('action' => 'edit', $this->Category->id));
                
            } else {
                $this->Session->setFlash(__('Saving failed, please fix the errors below.'));
            }
            
        } else {
            $this->request->data = $category;
        }

        $this->set('title_for_layout', __('Edit Category: %s', $category['Category']['name']));
        $this->set('parents', array(0 => '[ No Parent ]') + $this->Category->generateTreeList(null, null, null, " - "));
        $this->set(compact('category'));
    }

}