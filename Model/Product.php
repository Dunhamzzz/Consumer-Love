<?php

class Product extends AppModel {

    public $order = 'name';
    public $validate = array(
        'name' => array(
            'required_field' => array(
                'rule' => 'notEmpty',
                'allowEmpty' => false,
                'message' => 'Product or service must have a name!'
            ),
        ),
        'description' => array(
            'required_field' => array(
                'rule' => 'notEmpty',
                'allowEmpty' => false,
                'message' => 'Please enter a description.'
            )
        )
    );
    public $hasAndBelongsToMany = array('Category');
    public $hasMany = array('Inventory', 'Feed', 'Thread', 'News');
    public $actsAs = array(
        'Upload.Upload' => array(
            'logo' => array(
                'thumbnailQuality' => 100,
                'thumbsizes' => array(
                    '128x128' => '[128x128]',
                    '64x64' => '[64x64]',
                    '32x32' => '[32x32]'
                ),
                'thumbnailMethod' => 'php',
                'extensions' => array('.jpg', '.jpeg', '.png')
            )
        ),
        'Utils.Sluggable' => array(
            'label' => 'name',
            'method' => 'multibyteSlug',
            'separator' => ''
        ),
    );
    public $findMethods = array('active' => true, 'related' => true);

    protected function _findActive($state, $query, $results = array()) {
        if ($state == 'before') {
            $query['conditions'] = array_merge($query['conditions'], $this->activeConditions());
            return $query;
        }

        return $results;
    }

    protected function _findRelated($state, $query, $results = array()) {
        if ($state == 'before') {
            if (isset($query['product'])) {
                // find products where parent_id is that product, or they share the same parent id.
                $query['conditions']['parent_id'] = array($query['product']['Product']['id']);

                if (!empty($query['product']['Product']['parent_id'])) {
                    $query['conditions']['parent_id'][] = $query['product']['Product']['parent_id'];
                }
            }

            unset($query['product']);
            return $query;
        }

        return $results;
    }

    public function beforeSave() {
        if (!empty($this->data['Product']['description'])) {
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
     * Returns conditions for returning an active product
     */
    public function activeConditions() {
        return array('published' => 1, 'deleted' => 0);
    }

    /**
     * For searching, returns minimum data for search results
     * @param string $term
     * @param int $limit
     */
    public function search($term, $limit = 10, $order = 'name') {
        // Prevent wildcard searches
        $term = str_replace('%', ' ', $term);

        $conditions = array_merge(
                array('Product.name LIKE ?' => '%' . $term . '%'), $this->activeConditions()
        );

        return $this->find('active', array(
                    'conditions' => $conditions,
                    'fields' => array('name', 'logo', 'id', 'slug', 'inventory_count'),
                    'limit' => $limit,
                    'order' => 'Product.' . $order,
                    'contain' => false
                ));
    }

    /**
     * Returns an array of related products.
     * Products are classed as related if they share the same parent, are a child of, or are in the same category.
     * @param string $productId
     */
    public function related($productId, $limit = 10) {
        return $this->find('all', array(
            'joins' => array(
                'table' => 'categories_products',
                'alias' => 'CategoriesProducts',
                'type' => 'left',
                'conditions' => array(
                    'CategoriesProducts.product_id = Product.Id',
                    
                )
            ),
            'limit' => $limit
        ));
    }

    /*
$options['joins'] = array(
	array('table' => 'books_tags',
		'alias' => 'BooksTag',
		'type' => 'inner',
		'conditions' => array(
			'Books.id = BooksTag.books_id'
		)
	),
	array('table' => 'tags',
		'alias' => 'Tag',
		'type' => 'inner',
		'conditions' => array(
			'BooksTag.tag_id = Tag.id'
		)
	)
);

$options['conditions'] = array(
	'Tag.tag' => 'Novel'
);

$books = $Book->find('all', $options);
    
     */
    
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
        if (is_array($matches) && !empty($matches[1])) {
            $linkedWords = array();
            foreach ($matches[1] as $match) {
                $product = $this->findByName($match);
                $linkedWords[] = $product ? '<a href="/' . $product['Product']['slug'] . '" class="desc-link">' . $product['Product']['name'] . '</a>' : $match;
            }
        } else {
            return $description;
        }
        $formattedDescription = str_replace($matches[0], $linkedWords, $description);

        return $formattedDescription;
    }

}
