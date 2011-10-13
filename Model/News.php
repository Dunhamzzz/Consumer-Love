<?php

class News extends AppModel {

	public $belongsTo = array(
		'Product' => array('counterCache' => array('News.published' => true, 'News.deleted' => false)),
		'User' => array('counterCache' => array('News.published' => true, 'News.deleted' => false))
	);
	
	public $actsAs = array(
		'Utils.Sluggable' => array(
			'label' => 'title',
			'method' => 'multibyteSlug',
			'separator' => ''
		)
	);
	
	public $validate = array(
		'title' => array(
			'required' => true,
			'rule' => array('minLength', '10'),
			'message' => 'The title must be at least 10 characters long.'
		),
		'content' => array(
			'required' => true,
			'allowEmpty' => false,
			'rule' => array('minLength', '10'),
			'message' => 'Please post some content.'
		)
	);
	
	/**
	 * Handles User submitted news.
	 */
	public function submit($newsData, $userId) {
		// Check Product Exists
		$this->Product->id = $newsData['News']['product_id'];
		if(!$this->Product->exists()) {
			throw new DomainException(__('Invalid product.'));
		}
		
		// Check User Exists
		$this->User->id = $userId;
		if(!$this->User->exists()) {
			throw new DomainException(__('Invalid User.'));
		}
		
		$newsData['News']['user_id'] = $userId;
		$newsData['News']['deleted'] = 0;
		
		// @todo Logic to see if post is auto-published
		$newsData['News']['published'] = 1;
		
		return $this->add($newsData);
	}
	
	/**
	 * Adds a news item
	 */
	public function add($newsData) {
		$this->create();
		$this->save($newsData);
		
		return $this->read();
	}
	
}