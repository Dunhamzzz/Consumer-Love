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
	 * Returns an id => data array of products in a users' inventory
	 */
	public function getInventory($userId, $limit = null) {
		$query = array(
			'conditions' => array(
        		'Inventory.user_id' => $userId,
				'Product.active' => 1
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
			),
			'limit' => 1
		));
	}
	
	/**
	 * Toggles an item in a users inventory
	 * @return 0 for off, 1 for on, -1 for error
	 */
	public function toggle($productId, $userId) {
		$check = $this->has($productId, $userId);
		
		if(!empty($check)) {
			// User already has an entry, so delete it.
			$this->delete($check['Inventory']['id']);
			$status = 0;
		} else {
			// Not found, add it.
			$this->create();
			$inventory = array(
				'Inventory' => array(
					'user_id' => $userId,
					'product_id' => $productId
				)
			);
			$status = (bool) $this->save($inventory);
		}
		
		return $status;
	}
}