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
            if ($this->Product->add($this->request->data)) {
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
        $this->set('parents', $this->Product->Category->getAllThreaded());
    }

    public function admin_edit($id = null) {

        if ($this->request->is('post')) {
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash('Changes made to ' . $this->request->data['Category']['name'] . ' have been saved.');
                
                // If a new category was posted, redirect to main edit page.
                if(!$id) {
                    $this->redirect(array('action' => 'edit', $this->Category->id));
                }
                
            } else {
                $this->Session->setFlash('Saving Failed.');
            }
            
        } else {
            $this->Category->id = $id;
            if (!$this->Category->exists()) {
                //throw new NotFoundException(__('Invalid category'));
            }

        $category = $this->Category->read();
            $this->request->data = $category;
        }

        $title_for_layout = 'Edit Category: ' . $category['Category']['name'];
        $parents = array(0 => '[ No Parent ]') + $this->Category->generateTreeList(null, null, null, " - ");

        $this->set(compact('parents', 'category', 'title_for_layout'));
    }

}