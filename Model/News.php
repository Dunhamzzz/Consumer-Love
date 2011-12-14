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
		'content_raw' => array(
			'required' => true,
			'allowEmpty' => false,
			'rule' => array('minLength', '10'),
			'message' => 'Please post some content.'
		)
	);
	
	/**
	* Fetches a users timeline
	* @param $products array of product IDs
	* @return array News
	**/
	public function timeline($products = array(), $limit = 20 ) {
		return $this->find('all', array(
			'conditions' => array(
				'product_id' => $products,
				'News.published' => 1,
				'News.deleted' => 0
			), 
			'order' => array('News.created DESC'),
			'limit' => $limit
		));
	}
	
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
		
		// @todo add formatting
		$newsData['News']['content'] = htmlspecialchars($newsData['News']['content_raw']);
                
                $this->save($newsData);
		
		return $this->read();
	}
	
}