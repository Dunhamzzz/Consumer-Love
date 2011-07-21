<?php
/**
 * Custom helper for Consumer Love <3
 * @author Matthew Dunham
 *
 */
class LoveHelper extends AppHelper {
	public $helpers = array('Html', 'Text');
	
	public function inventoryButton($productId, $inInventory = false) {
		return $this->Html->link('Inventory',
			array('controller' => 'inventories', 'action' => 'toggle', $productId),
			array('class' => 'toggle-inventory cta'. ($inInventory ? ' in' : '')));
	}
	
	// Retursn a link to a category
	public function categoryLink($category, $anchorText = false, $htmlAttrs = array()) {
		$category = $this->_extractCategory($category);
		$anchorText = $anchorText ?: $category['name'];
	
		return $this->Html->link(
			$anchorText,
			array(
				'controller' => 'categories',
				'action' => 'view',
				'admin' => false,
				'slug' => $category['slug']
			),
			$htmlAttrs
		);
	}
	
	// Returns a product image
	public function productImage($product, $size = 32, $url = false) {
		$product = $this->_extractProduct($product);
		
		if($url) {
			return '/img/logos/products/thumb/'.$size.'x'.$size.'/'.$product['logo'];
		} else {
			return '<span class="product-logo s'.$size.'">'.$this->Html->image(
				'logos/products/thumb/'.$size.'x'.$size.'/'.$product['logo'],
				array(
					'alt' => $product['name']
				)
			).'</span>';
		}
	}
	
	// Returns a list of categories a product is in.
	public function listProductCategories($product) {
		$categoryList = array();
		foreach($product['Category'] as $category) {
			$categoryList[] = $this->categoryLink($category);
		}
		
		return $this->Text->toList($categoryList);
	}
	
	// Returns a link to a profile
	public function userLink($user, $htmlAttrs = array()) {
		$user = $this->_extractRow('User', $user);
		return $this->Html->link($user['username'], array(
				'controller' => 'users',
				'action' => 'view',
				'admin' => false,
				$user['slug']
			),
			$htmlAttrs
		);
	}
	
	// Wrappers for _extractRow()
	private function _extractProduct($product) {
		return $this->_extractRow('Product', $product);
	}
	
	private function _extractCategory($category) {
		return $this->_extractRow('Category', $category);
	}
	
}