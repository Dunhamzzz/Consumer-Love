<?php
class ProductsController extends AppController {

	public $paginate = array(
		'Product' => array(
			'order' => 'Product.name'
		),
		'Thread' => array(
			'order' => 'Thread.modified DESC'
		),
		'News' => array(
			'order' => 'News.created DESC',
			'conditions' => array(
				'published' => 1,
				'deleted' => 0
			),
			'contain' => array(
				'User' => array('username', 'slug')
			)
		)
	);
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'view', 'autocomplete', 'top5');
	}

	public function view($slug = null) {
		$product = $this->Product->getBySlug($slug);
		
		if(!$product) {
			throw new NotFoundException(__('Invalid Product'));
		}
		
		// Get Threads, we need to paginate it
		$threads = $this->paginate('Thread', array('product_id' => $product['Product']['id']));
		
		// Paginate News
		$news = $this->paginate('News', array('product_id' => $product['Product']['id']));
		
		// Is this in the users inventory?
		if($this->userData) {
			$inInventory = $this->Product->Inventory->has($product['Product']['id'], AuthComponent::user('id'));
			if(!empty($inInventory)) {
				$this->request->data = $inInventory;
			}
			$this->set(compact('inInventory'));
		}
		
		// Related Products
		$related = $this->Product->related($product['Product']['id']);
		
		$canonical = '/' . $product['Product']['slug'];

		$this->set('title_for_layout', $product['Product']['name'].' &hearts;');
		$this->set(compact('product', 'category', 'threads', 'canonical', 'related', 'news'));
	}
	
	// Page for users to suggest products for us to cover
	public function suggest() {
		if(empty($this->request->data) && isset($this->params['url']['suggestion'])) {
			$this->request->data['Product']['name'] = $this->params['url']['suggestion'];
		}
	}
	
	// Shows users who own a certain product
	public function users($slug = null) {
		$product = $this->Product->getBySlug($slug);
		
		if(!$product) {
			throw new NotFoundException(__('Invalid Product'));
		}
		
		$users = $this->Product->Inventory->haveProduct($product['Product']['id']);
		
		$this->set(compact('product', 'users'));
		
	}
	
	/** Ajax Actions **/
	public function autocomplete() {
		if (!$this->request->is('ajax')) {
			throw new MethodNotAllowedException();
		}
		
		$term = $this->request->query['q'];
		$products = $this->Product->search($term);
		$categories = $this->Product->Category->search($term);
		
		$this->set(compact('products', 'categories', 'term'));
	}
	
	public function top5($categoryId) {
		// Put this in model
		if (!$this->request->is('ajax')) {
			throw new MethodNotAllowedException();
		}
		$top5Category = $this->Product->Category->find('first',array(
			'conditions' => array(
				'Category.id' => $categoryId
			),
			array('contain' => false)
		));
		$top5Products = $this->Product->topByCategoryId($categoryId);
		$this->set(compact('top5Category', 'top5Products'));
	}
	
	/** Admin Functions **/
	public function admin_index() {
		$this->set('title_for_layout', 'Manage Products');
		$this->set('products', $this->paginate());
	}
	
	// Admin Add and Edit functions
	public function admin_new() {
		
		if($this->request->is('post')) {
			$this->request->data['Product']['published'] = 1;
			$this->request->data['Product']['deleted'] = 0;
			
			if($this->Product->add($this->request->data)) {
				$this->Session->setFlash($this->request->data['Product']['name'].' have been saved.');
	
				$this->redirect(array(
					'controller' => 'products',
					'action' => 'edit',
					'admin' => true,
					$this->Product->id
				));
			}
		}
		
		$title_for_layout = 'Add Product';
		$categories = $this->Product->Category->getAllThreaded(true);
		
		$this->set(compact('categories', 'title_for_layout'));
	}
	
	public function admin_edit($id = null) {
		$this->Product->id = $id;
		if(!$this->Product->exists()) {
			throw new NotFoundException('Invalid product ID.');
		}

		if($this->request->is('put')) {
			if($this->Product->update($this->request->data)) {
				$this->Session->setFlash('Changes made to '.$this->request->data['Product']['name'].' have been saved.');
			} else {
				$this->Session->setFlash('Saving Failed.');
			}
		} else {
			$this->request->data = $this->Product->read();	
		}
		
		$title_for_layout = 'Edit '.$this->request->data['Product']['name'];
		$categories = $this->Product->Category->getAllThreaded(true);
		
		$this->set(compact('categories', 'title_for_layout'));
	}
	
	public function admin_delete($id) {
		
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		
		if ($this->Product->delete($id)) {
			$this->Session->setFlash(__('Product deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Product was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	public function admin_rebuildesc() {
		die('Died in controller');
		$products = $this->Product->find('all');
		foreach($products as $product) {
			$this->Product->id = $product['Product']['id'];
			$this->Product->saveField('description_formatted', $this->Product->formatDescription($product['Product']['description']));
		}
	}

}