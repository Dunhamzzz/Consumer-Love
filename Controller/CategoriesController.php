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
		$categories =  $this->Category->getAllThreaded();

		$this->set(compact('categories'));
	}

	public function view($slug) {
		$this->Category->contain(false);
		$category = $this->Category->findBySlug($slug);
		if(!$category) {
			throw new NotFoundException(__('Invalid category'));
		}
		
		$path = $this->Category->getPath($category['Category']['id']);
		
		// Make custom method
		if(isset($this->params['data']['sort'], $this->params['data']['order']) ) {
			$this->paginate['Product']['order'] = array($this->params['data']['sort'] => $this->params['data']['order']);
		}
		
		
		// @todo use 2.0 paginator
		$products = $this->paginate($this->Category->Product, array(
			'CategoryFilter.category_id' => $category['Category']['id']
		));
		
		$this->set(compact('category', 'products', 'path'));
		$this->set('title_for_layout', $category['Category']['name']);
	}
	
	/** Admin Actions **/
	
	public function admin_index() {
		$categories = $this->Category->getAllThreaded();
		
		$title_for_layout = 'Manage Categories';
		$this->set(compact('title_for_layout', 'categories'));
	}
	
	public function admin_new() {	
		if($this->request->is('post')) {
			if($this->Product->add($this->request->data)) {
				$this->Session->setFlash($this->request->data['Category']['name'].' have been saved.');
	
				$this->redirect(array(
					'controller' => 'categories',
					'action' => 'edit',
					'admin' => true,
					$this->Category->id
				));
			}
		}
		
		$title_for_layout = 'Add Product';
		$categories = $this->Product->Category->getAllThreaded(true);
		
		$this->set(compact('categories', 'title_for_layout'));
	}

	public function admin_edit($id = null) {
		$this->Category->id = $id;
		if(!$this->Category->exists()) {
			throw new NotFoundException(__('Invalid category'));
		}

		$category = $this->Category->read();	

		if($this->request->is('put')) {
			if($this->Category->update($this->request->data)) {
				$this->Session->setFlash('Changes made to '.$this->request->data['Category']['name'].' have been saved.');
			} else {
				$this->Session->setFlash('Saving Failed.');
			}
		} else {
			$this->request->data = $category;
		}
		
		$title_for_layout = 'Edit Category: '.$category['Category']['name'];
		$parents = array(0 => '[ No Parent ]') + $this->Category->generateTreeList(null,null,null," - ");
		
		$this->set(compact('parents', 'category', 'title_for_layout'));
	
	}

}