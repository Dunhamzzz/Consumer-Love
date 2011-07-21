<?php
class Feed extends AppModel {
	
	public $belongsTo = array('Product', 'User');
	
	public function add($data) {
		$this->save(array(
			'user_id' => User::get('id') ?: null,
			'product_id' => $data['product_id'],
			'type' => $data['type'],
			'content' => $data['content'],
			'display' => 1
		));
	}
	
	// Get a feed by product(s)
	public function getFeed($productIds, $offset = 0, $limit = 25) {
		return $this->find('all', array(
			'conditions' => array(
				'product_id' => $productIds
			),
			'fields' => array(
				'Product.name', 'Product.slug', 'Product.logo',
				'User.username', 'User.email', 'User.slug',
				'Feed.*'
			),
			'limit' => $limit
		));
	}
	
	// Get a feed by User
	public function getUserFeed($userId = null, $offset = 25) {
		if(!$userId) {
			$userId = User::get('id');
		}
		
		return $this->find('all', array(
			'conditions' => array(
				'user_id' => $userId
			),
			'fields' => array(
				'Product.name', 'Product.slug', 'Product.logo',
				'User.username', 'User.email', 'User.slug',
				'Feed.*'
			)
		));
	}
}