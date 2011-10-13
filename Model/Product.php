<?php
class Product extends AppModel {
	
	public $order = 'name';
	
	public $validate = array(
		'category_id' => array(
			'numeric' => array(
				'rule' => array('numeric')
			),
		),
		'name' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'allowedEmpty' => false,
				'message' => 'Product or service must have a name!'
			),
		),
		'description' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'allowedEmpty' => false,
				'message' => 'Please enter a description.'
			)
		),
		'twitter' => array(
			'rule' => 'validateTwitter',
			'allowEmpty' => true,
			'message' => 'This Twitter account is not valid.'
		)
	);

	public $hasAndBelongsToMany = array('Category');
	public $hasMany = array('Inventory', 'Feed', 'Thread', 'News');
	
	public $actsAs = array(
	 /*   'MeioUpload' => array(
			'logo' => array(
				'dir' => 'img{DS}logos{DS}products',
				'create_directory' => false,
				'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png'),
	            'allowed_ext' => array('.jpg', '.jpeg', '.png'),
				 'thumbsizes' => array(
	           		'128x128' => array('width' => 128, 'height' => 128),
					'64x64' => array('width' => 64, 'height' => 64),
					'32x32' => array('width' => 32, 'height' => 32),
				),
				'default' => 'default.png'
			)
		),*/
		'Utils.Sluggable' => array(
			'label' => 'name',
			'method' => 'multibyteSlug',
			'separator' => ''
		)
	);
	
	public function beforeSave() {
		if(!empty($this->data['Product']['description'])) {
			$this->data['Product']['description_formatted'] = $this->formatDescription($this->data['Product']['description']);
		}
		return true;
	}
	
	public function afterSave($created) {
		parent::afterSave($created);
		Cache::delete('product_slugs');
	}
	
	public function afterDelete() {
		parent::afterDelete();
		Cache::delete('product_slugs');
	}
	
	/**
	 * For searching, returns minimum data for search results
	 * @param string $term
	 * @param int $limit
	 */
	public function search($term, $limit = 10) {
		// Prevent wildcard searches
		$term = str_replace('%', ' ', $term);
		
		return $this->find('all', array(
			'conditions' => array(
				'Product.name LIKE ?' => '%'.$term.'%',
			),
			'fields' => array('name', 'logo', 'id', 'slug', 'inventory_count'),
			'limit' => $limit,
			'order' => 'Product.name',
			'contain' => false
		));
	}
	
	/**
	 * Returns an array of related products. For now just grabs from the same categories.
	 * @param string $productId
	 */
	public function related($productId, $limit = 10) {
		return 1;
		return $this->find('all', array(
			'joins' => array(
				'table' => 'categories_products',
				'alias' => 'CategoriesProducts',
				'type' => 'left',
				'conditions' => array(
					'CategoriesProducts.product_id => '
				)
			),
			'limit' => $limit
		));
	}
	
	/**
	 * Returns a product row from a slug.
	 * @param string $slug
	 */
	public function getBySlug($slug) {
		return $this->find('first', array(
			'conditions' => array(
				'slug' => $slug
			),
			'contain' => array('Category')
		));
	}
	
	// Same as above, but from ID
	public function getById($id) {
		return $this->find('first', array(
			'conditions' => array(
				'id' => $id
			),
			'contain' => array('Category')
		));
	}
	
	public function getInfoForMeta($conditions) {
	}
	
	public function topByCategoryId($categoryId, $count = 5) {
		$this->bindModel(array('hasOne' => array('CategoriesProduct')));
		$products = $this->find('all', array(
			'conditions' => array(
				'CategoriesProduct.category_id' => $categoryId
			),
			'contain' => array('CategoriesProduct'),
			'order' => array('Product.inventory_count DESC', 'Product.name'),
			'limit' => $count
		));
		return $products;
	}

	// Replaces double curly-braced words with links to their product/category.
	public function formatDescription($description) {
		preg_match_all('/{{([A-Za-z0-9 _-]+)}}/', $description, $matches);
		if(is_array($matches) && !empty($matches[1])) {
			$linkedWords = array();
			foreach($matches[1] as $match) {
				$product = $this->findByName($match);
				$linkedWords[] = $product ? '<a href="/'.$product['Product']['slug'].'" class="desc-link">'.$product['Product']['name'].'</a>' : $match;
			}
		} else {
			return $description;
		}
		$formattedDescription = str_replace($matches[0], $linkedWords, $description);
		
		return $formattedDescription;
	}
}
