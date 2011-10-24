<?php
// Router to cache product names and read routes so we can have /productName

App::import('Core', 'Router');
App::import('Utility', 'ClassRegistry');

class ProductRoute extends CakeRoute {
	
	public function match($url) {
		
		if(!empty($url['productSlug']) && $this->_exists($url['productSlug'])) {
			return parent::match($url);
		}
		return false;
	}
	
	public function parse($url) {
		$params = parent::parse($url);
		if(!empty($params) && $this->_exists($params['productSlug'])) {
			return $params;
		}
		return false;
	}
	
	protected function _exists($productSlug) {
		$productSlugs = Cache::read('product_slugs');
		
		if(empty($productSlugs)) {
			$products = ClassRegistry::init('Product')->find('all', array(
				'fields' => 'slug',
				'recursive' => -1,
				'conditions' => array('published' => 1)
			));
			
			if(!empty($products)) {
				$productSlugs = array_map(
					'strtolower',
					Set::extract('/Product/slug', $products)
				);
				Cache::write('product_slugs', $productSlugs);
			}
		}

		return in_array($productSlug, (array) $productSlugs);
	}
}