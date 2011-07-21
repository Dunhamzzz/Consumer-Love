<?php
class Inventory extends AppModel {
	public $belongsTo = array('Product', 'User');
	
	public $validate = array(
		
	);
	
	/**
	 * Returns an id => data array of products in a users' inventory
	 *
	 */
	public function getUserInventory($userId) {
		$inventory = $this->find('all', array(
			'conditions' => array(
        		'Inventory.user_id' => $userId,
				'Product.active' => 1
        	),
        	'fields' => array('Product.id', 'Product.name', 'Product.slug', 'Product.logo'),
        	'contain' => 'Product'
		));
		
		if(!empty($inventory)) {
			return Set::combine($inventory, '{n}.Product.id', '{n}.Product');
		}
		return false;
	}
	
	/**
	 * Checks whether a product is in a users inventory
	 */
	public function isInInventory($productId, $userId = null) {
		if(!$userId) {
			return in_array($productId, array_keys(self::get()));
		}
		
		return $this->find('count', array(
			'conditions' => array(
				'user_id' => $userId,
				'product_id' => $productId
			)
		));
	}
	
	/**
	 * Toggles an item in a users inventory
	 * @return 0 for off, 1 for on, -1 for error
	 */
	public function toggle($productId, $userId) {
		// Check ProductID
		$product = $this->Product->read('id', $productId);
		if(!empty($product)) {
			$check = $this->isInInventory($productId);
			if($check > 0) {
				// User already has an entry, so delete it.
				$this->deleteAll(array('product_id' => $productId, 'user_id' => $userId), false);
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
		} else {
			$status = -1;
		}
		
		return $status;
	}
	
	public static function get() {
		$inventory = Configure::read('Inventory');
		
		if(empty($inventory)) {
			return array();
		}
		
		return $inventory;
	}
}