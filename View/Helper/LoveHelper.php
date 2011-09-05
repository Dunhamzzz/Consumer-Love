<?php
/**
 * Custom helper for Consumer Love <3
 * @author Matthew Dunham
 *
 */
class LoveHelper extends AppHelper {
	public $helpers = array('Html', 'Text');
	
	public function inventoryButton($productId, $inInventory = false) {
		return $this->Html->link(
			'<span class="icon"></span> Inventory',
			array('controller' => 'inventories', 'action' => 'toggle', $productId),
			array('class' => 'toggle-inventory cta'. ($inInventory ? ' in' : ''), 'escape' => false)
		);
	}
	
	// Retursn a link to a category
	public function categoryLink($category, $anchorText = false, $htmlAttrs = array()) {
		$category = $this->extractCategory($category);
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
	public function productImage($product, $size = 32, $url = false, $htmlAttrs = array()) {
		$product = $this->extractProduct($product);
		
		if($url) {
			return '/img/logos/products/thumb/'.$size.'x'.$size.'/'.$product['logo'];
		} else {
			return '<span class="product-logo s'.$size.'">'.$this->Html->image(
				'logos/products/thumb/'.$size.'x'.$size.'/'.$product['logo'],
				array(
					'alt' => $product['name'],
					'title' => $product['name']
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
	
	// Wrappers for extractRow()
	private function extractUser($user) {
		return $this->extractRow('User', $user);
	}
	
	private function extractProduct($product) {
		return $this->extractRow('Product', $product);
	}
	
	private function extractCategory($category) {
		return $this->extractRow('Category', $category);
	}
	
}