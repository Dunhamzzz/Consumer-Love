<?php
class ProductsController extends AppController {

	public $name = 'Products';
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
			$this->Session->setFlash('Invalid product');
			$this->redirect(array('action' => 'index'));
		}
		
		// Get Threads, we need to paginate it
		$threads = $this->paginate('Thread', array('product_id' => $product['Product']['id']));
		
		// Is this in the users inventory?
		if($this->Auth->user()) {
			$this->set('inventory', $this->Product->Inventory->isInInventory($product['Product']['id'], $this->userData['User']['id']));
		}
		
		$this->set(compact('product', 'category', 'threads'));
		$this->set('title_for_layout', $product['Product']['name'].' &hearts;');
	}
    
	// Page for users to suggest products for us to cover
	public function suggest() {
		if(empty($this->data) && isset($this->params['url']['suggestion'])) {
			$this->data['Product']['name'] = $this->params['url']['suggestion'];
		}
	}
	
	/** Ajax Actions **/
	public function autocomplete() {
		if ($this->isApiCall()) {
			$term = $this->params['url']['q'];
			$products = $this->Product->find('all', array(
				'conditions' => array(
					'Product.name LIKE' => '%'.$term.'%',
				),
				'fields' => array('name', 'logo', 'id', 'slug'),
				'limit' => 7,
				'order' => 'Product.name',
				'contain' => false
			));
			
			$categories = $this->Product->Category->find('all', array(
				'conditions' => array(
					'Category.name LIKE' => '%'.$term.'%'
				)
			));
			$this->set(compact('products', 'categories', 'term'));
		} else {
			$this->cakeError('error404');
		}
	}
	
	public function top5($categoryId) {
		// Put this in model
		if ($this->isApiCall()) {
			$top5Category = $this->Product->Category->find('first',array(
				'conditions' => array(
					'Category.id' => $categoryId
				),
				array('contain' => false)
			));
			$top5Products = $this->Product->topByCategoryId($categoryId);
			$this->set(compact('top5Category', 'top5Products'));
		} else {
			$this->cakeError('error404');
		}
	}
	
	/** Comment Callback **/
	public function callback_commentsAfterAdd($data) {
		$this->Product->id = $data['modelId'];
		$this->Product->Feed->add(array(
			'product_id' => $data['modelId'],
			'type' => 'comment',
			'content' => '{user} commented on {product}'
		));
	}
	
	/** Admin Functions **/
	public function admin_index() {
		$this->set('products', $this->paginate());
	}
	
	public function admin_edit($id = null) {
		$this->Product->id = $id;
		if($id && empty($this->data)) {
			$this->data = $this->Product->read();
			if(empty($this->data)) {
				$this->Session->setFlash('Invalid product ID.');
				$this->redirect(array('action' => 'index'));
			}
			
			$this->set('title_for_layout','Edit '.$this->data['Product']['name']);
			$this->set('pageAction', 'edit');
		} else {
			// Saving a product
			if(!empty($this->data)) { //Saving
				if($this->Product->save($this->data)) {
					if($id) {
						$this->Session->setFlash('Changes made to '.$this->data['Product']['name'].' have been saved.');
					} else {
						$this->Session->setFlash($this->data['Product']['name'].' have been saved.');
					}
					$this->data = $this->Product->read();
				}
				
				$this->set('title_for_layout','Edit '.$this->data['Product']['name']);
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