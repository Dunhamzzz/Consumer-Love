<?php
class LinkHelper extends AppHelper {
	
	public $helpers = array('Html', 'Text');
	
	// Returns a link to a product
	public function product($product, $anchorText = false, $htmlAttrs = array()) {
		$product = $this->_extractRow('Product', $product);
		$anchorText = $anchorText ?: $product['name'];
	
		return $this->Html->link(
			$anchorText,
			array(
				'controller' => 'products',
				'action' => 'view',
				'admin' => false,
				'productSlug' => $product['slug']
			),
			$htmlAttrs
		);
	}
	
	
	// Links to a forum
	public function forum($productSlug, $anchorText = 'Forum', $htmlAttrs = array()) {
		if(is_array($productSlug)) {
			$product = $this->_extractRow('Product', $productSlug);
			$productSlug = $product['slug'];
		}
		
		return $this->Html->link($anchorText, array(
			'controller' => 'threads',
			'action' => 'all',
			'productSlug' => $productSlug
		));
	}
	
	// To a Thread
	public function thread($thread, $htmlAttrs = array()) {
		return $this->Html->link($thread['Thread']['title'], array(
			'controller' => 'threads',
			'action' => 'view',
			'threadSlug' => $thread['Thread']['slug'],
			'productSlug' => $thread['Product']['slug']
		), $htmlAttrs);
	}
}