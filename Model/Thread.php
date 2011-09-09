<?php
class Thread extends AppModel {
	public $belongsTo = array(
		'Product',
		'User',
		'FirstPost' => array(
			'className' => 'Post',
			'foreignKey' => 'first_post_id'
		),
		'LastPost' => array(
			'className' => 'Post',
			'foreignKey' => 'last_post_id'
		)
	);
	
	public $hasMany = array('Post');
	
	public $actsAs = array(
	// @todo work out why this breaks a save
		'Utils.Sluggable' => array(
			'label' => 'title',
			'method' => 'multibyteSlug',
			'separator' => '-',
			'slug' => 'slug',
			'length' => 150
		)
	);
	
	public function add($data) {
		$this->set($data);
		
		if($this->validates()) {
			
			$this->create();
			$this->save($data, false, array('product_id', 'user_id', 'title', 'published', 'user_ip', 'content'));
			
			$threadId = $this->id;
			$userId = $data['Thread']['user_id'];
			$postId = $this->Post->addFirst($threadId, $data['Thread']);
			
			// Now update last post IDs etc
			$this->set(array(
				'first_post_id' => $postId,
				'last_post_id' => $postId,
				'last_user_id' => $userId
			));
			
			$this->save();
			
			return $threadId;
			
		} else {
			return false;
		}
	}
	
	// Optionally accpets product ID to speed the find
	public function getBySlug($slug, $productId = null) {
		
		$conditions = array('Thread.slug' => $slug);
		
		if(!is_null($productId)) {
			$conditions['Thread.product_id'] = $productId;
		}
		
		return $this->find('first', array(
			'conditions' => $conditions,
			'contain' => array(
				'Product', 'User', 'FirstPost'
			)
		));
	}
	
	public function getForReply($threadId) {
		return $this->find('first', array(
			'conditions' => array(
				'Thread.id' => $threadId
			),
			'contain' => array(
				'Product'
			)
		));
	}
}