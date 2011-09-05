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
		'Utils.Sluggable' => array(
			'label' => 'title',
			'method' => 'multibyteSlug',
			'separator' => '-',
			'slug' => 'slug',
			'length' => 150
		)
	);
	
	public function addThread($data) {
		$this->set($data);
		
		if($this->validates()) {
			
			$this->create();
			$this->save($data, false, array('product_id', 'user_id', 'title', 'published'));
			
			$threadId = $this->id;
			$userId = $data['Thread']['user_id'];
			$postId = $this->Post->addFirstPost($threadId, $data['Thread']);
			
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
	
	public function getSlugsById($threadId) {
		return $this->find('first', array(
			'conditions' => array('Thread.id' => $threadId),
			'fields' => array('Thread.title', 'Thread.slug', 'Product.slug')
		));
	}
	
	public function getThreadForViewing($slug) {
		return $this->find('first', array(
			'conditions' => array(
				'Thread.slug' => $slug
			),
			'contain' => array(
				'Product', 'User', 'FirstPost'
			)
		));
	}
	
	public function getThreadForReply($threadId) {
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