<?php
class ProductsController extends AppController {

	public $paginate = array(
		'Product' => array(
			'order' => 'Product.name'
		),
		'Thread' => array(
			'order' => 'Thread.modified DESC'
		)
		
	);
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'view', 'autocomplete', 'top5');
	}

	public function view($slug = null) {
		$product = $this->Product->find('first', array(
			'conditions' => array(
				'Product.slug' => $slug
			),
			'contain' => array('Category')
		));
		
		if(!$product) {
			throw new NotFoundException(__('Invalid Product'));
		}
		
		// Get Threads, we need to paginate it
		// @todo Use 2.0 paginator
		$threads = $this->paginate('Thread', array('product_id' => $product['Product']['id']));
		
		// Is this in the users inventory?
		if($this->userData) {
			$this->set('inInventory', $this->Product->Inventory->has($product['Product']['id'], $this->userData['id']));
		}
		
		$this->set(compact('product', 'category', 'threads'));
		$this->set('title_for_layout', $product['Product']['name'].' &hearts;');
	}
	
	// Page for users to suggest products for us to cover
	public function suggest() {
		if(empty($this->request->data) && isset($this->params['url']['suggestion'])) {
			$this->request->data['Product']['name'] = $this->params['url']['suggestion'];
		}
	}
	
	// Shows users who own a certain product
	public function users($slug = null) {
		
	}
	
	/** Ajax Actions **/
	public function autocomplete() {
		if ($this->request->is('ajax')) {
			$term = $this->request->query['q'];
			$products = $this->Product->search($term);
			$categories = $this->Product->search($term);
			$categories = $this->Product->Category->search($term);
			
			$this->set(compact('products', 'categories', 'term'));
		} else {
			throw NotFoundException(__('Page not found.'));
		}
	}
	
	public function top5($categoryId) {
		// Put this in model
		if ($this->request->is('ajax')) {
			$top5Category = $this->Product->Category->find('first',array(
				'conditions' => array(
					'Category.id' => $categoryId
				),
				array('contain' => false)
			));
			$top5Products = $this->Product->topByCategoryId($categoryId);
			$this->set(compact('top5Category', 'top5Products'));
		} else {
			throw NotFoundException(__('Page not found.'));
		}
	}
	
	/** Admin Functions **/
	public function admin_index() {
		$this->set('title_for_layout', 'Manage Products');
		$this->set('products', $this->paginate());
	}
	
	// @todo re-do this, not worth the fat controller
	public function admin_edit($id = null) {
		$this->Product->id = $id;
		if($id && empty($this->request->data)) {
			$this->request->data = $this->Product->read();
			if(empty($this->request->data)) {
				$this->Session->setFlash('Invalid product ID.');
				$this->redirect(array('action' => 'index'));
			}
			
			$this->set('title_for_layout','Edit '.$this->request->data['Product']['name']);
			$this->set('pageAction', 'edit');
		} else {
			// Saving a product
			if(!empty($this->request->data)) { //Saving
				if($this->Product->save($this->request->data)) {
					if($id) {
						$this->Session->setFlash('Changes made to '.$this->request->data['Product']['name'].' have been saved.');
					} else {
						$this->Session->setFlash($this->request->data['Product']['name'].' have been saved.');
					}
					$this->request->data = $this->Product->read();
				}
				
				$this->set('title_for_layout','Edit '.$this->request->data['Product']['name']);
				$this->set('pageAction', 'edit');
			} else {
				$this->set('title_for_layout', 'Add Product');
				$this->set('pageAction', 'add');
			}
		}
		
		$categories = $this->Product->Category->getAllThreaded(true);
		$this->set(compact('categories'));
	}
	
	public function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for product', true));
			$this->redirect(array('action'=>'index'));
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