<?php
class Inventory extends AppModel {
	public $belongsTo = array(
		'Product' => array(
			'counterCache' => true
		),
		'User' => array(
			'counterCache' => true
		)
	);
	
	public $validate = array(
		
	);
	
	/**
	 * Removes a product from a users inventory
	 * @param string $productId
	 * @param string $userId
	 */
	public function remove($productId, $userId) {
		return $this->deleteAll(array(
			'product_id' => $productId,
			'user_id' => $userId
		));
	}
	
	public function add($productId, $userId) {
		$this->create();
		$inventory = array(
			'Inventory' => array(
				'user_id' => $userId,
				'product_id' => $productId
			)
		);
		return $this->save($inventory);
	}
	
	/**
	 * Returns an id => data array of products in a users' inventory
	 */
	public function get($userId, $limit = null) {
		$query = array(
			'conditions' => array(
        		'Inventory.user_id' => $userId,
				'Product.published' => 1
        	),
        	'order' => 'created ASC',
        	'fields' => array('Product.id', 'Product.name', 'Product.slug', 'Product.logo', 'Product.description_formatted', 'Inventory.created'),
        	'contain' => 'Product'
		);
		
		if(is_numeric($limit)) {
			$query['limit'] = $limit;
		}

		$inventory = $this->find('all', $query) ;
		
		if(!empty($inventory)) {
			return Set::combine($inventory, '{n}.Product.id', '{n}.Product');
		}
		return false;
	}
	
	/**
	 * Checks whether a product is in a users inventory
	 */
	public function has($productId, $userId) {
		return $this->find('first', array(
			'conditions' => array(
				'user_id' => $userId,
				'product_id' => $productId
			)
		));
	}
	
	/**
	 * Toggles an item in a users inventory
	 * @return bool
	 */
	public function toggle($productId, $userId) {
		$check = $this->has($productId, $userId);
		
		if(empty($check)) {
			return $this->add($productId, $userId);
		}
		
		// User already has an entry, so delete it.
		$this->remove($productId, $userId);
		return false;
	}
	
	/**
	 * Scores an owned product up or down
	 * @param $inventory Inventory row.
	 * @param $score string 'up' or 'down'.
	 */
	public function score($inventory, $score) {
		
		if($score == 'up') {
			$score = 1;
		} elseif($score == 'down') {
			$score = -1; // Can't seem to save -1 as an int with Cake
		} else {
			throw new Exception('Invalid vote received.');
		}
		
		$inventory['Inventory']['score'] = $score;
		$inventory['Inventory']['score_date'] = date('Y-m-d');
		
		if(!$this->save($inventory['Inventory'], false, array('score', 'score_date'))) {
			throw new DomainException('An internal error occured.');
		}
		
		return true;
	}
	
	/**
	 * Returns all the users who have a product
	 * @param string $productId
	 * @return array
	 */
	public function haveProduct($productId) {
		return $this->find('all', array(
			'conditions' => array(
				'product_id' => $productId
			),
			'contain' => array('User')
		));
	}
}