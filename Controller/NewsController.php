<?php
class NewsController extends AppController {
	
	public function submit() {
		$products = $this->News->Product->find('list');
		
		$title_for_layout = 'Submit News';
		$this->set(compact('products', 'title_for_layout'));
	}
	
}