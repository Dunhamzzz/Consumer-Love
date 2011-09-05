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

	public function admin_edit($id = null) {
		$this->Category->id = $id;
		
		if($id && !$this->request->is('post')) {
			
			if(!$this->Category->exists()) {
				throw new NotFoundException(__('Invalid category'));
			}
			
			$this->request->data = $this->Category->read(null, $id);
			$this->set('title_for_layout','Edit '.$this->request->data['Category']['name']);
			$this->set('pageAction', 'edit');
			
		} else {
			if($this->request->is('post') || $this->request->is('put')) { //Saving
				if($this->Category->save($this->request->data)) {
					$this->Session->setFlash('Changes made to '.$this->request->data['Category']['name'].' have been saved.');
					$this->request->data = $this->Category->read(null, $id);
				}
				
				$this->set('title_for_layout','Edit '.$this->request->data['Category']['name']);
				$this->set('pageAction', 'edit');
			} else {
				$this->set('title_for_layout', 'Add Category');
				$this->set('pageAction', 'add');
			}
		}
		
		$parents = array(0 => '[ No Parent ]') + $this->Category->generatetreelist(null,null,null," - ");
		$this->set(compact('parents'));
	}

}