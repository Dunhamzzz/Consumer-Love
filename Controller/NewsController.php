<?php
class NewsController extends AppController {
	
	public function view($slug) {
		
		$news = $this->News->find('first', array(
			'conditions' => array(
				'News.slug' => $slug,
				'News.deleted' => 0,
				'News.published' => 1
			),
			'contain' => array(
				'User' => array('username', 'slug')
			)
		));
		
		if(!$news) {
			throw new NotFoundException('Invalid News Item');
		}
		
		// Get product
		$product = $this->News->Product->getById($news['News']['product_id']);
		
		$title_for_layout = $news['News']['title'];
		$this->set(compact('title_for_layout', 'news', 'product'));
	}
	
	public function submit($productSlug) {
		$product = $this->News->Product->getBySlug($productSlug);
		
		if(!$product) {
			throw new NotFoundException(__('Invalid Product'));
		}
		
		if($this->request->is('post')) {
			
			$this->request->data['News']['product_id'] = $product['Product']['id'];
			
			try {
				$news = $this->News->submit($this->request->data, AuthComponent::user('id'));
			} catch(Exception $e) {
				$this->setFlash($e->getMessage);
			}

			if($news !== false) {
				$this->Session->setFlash(__('Thanks for submiting your %s news.', htmlspecialchars($product['Product']['name'])));
				$this->redirect(array('controller' => 'news', 'action' => 'view', 'newsSlug' => $news['News']['slug']));
			}
		}
		
		// For some reason the invalid fields won't register unless I do this
		//$this->News->invalidFields();
		
		$title_for_layout = __('Submit %s News', $product['Product']['name']);
		$this->set(compact('product', 'title_for_layout'));
	}
	
}