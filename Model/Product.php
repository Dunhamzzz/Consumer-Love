<?php

/**
 * Product Model. 
 */
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
    
    public $hasAndBelongsToMany = array(
        'Category' => array('unique' => 'keepExisting')
    );
    
    public $hasMany = array(
        'Inventory',
        'Thread',
        'News',
        'ProductImage'
    );
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
    public $findMethods = array('active' => true);

    protected function _findActive($state, $query, $results = array()) {
        if ($state == 'before') {
            $query['conditions'] = array_merge($query['conditions'], $this->activeConditions());
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
     * Products are classed as related if they share the same parent, are the parent/a child of, or are in the same category.
     * @param array $product
     */
    public function related($product, $limit = 8) {

        // Children of product
        $conditions = array(
            'OR' => array(array('Product.parent_id' => $product['Product']['id'])), // Children of product),
            'Product.id <>' => $product['Product']['id'],
            'Product.published' => 1
        );

        // Siblings and parent of product if applicable
        if (!empty($product['Product']['parent_id'])) {

            $conditions['OR'][] = array('Product.parent_id' => $product['Product']['parent_id']);
            $conditions['OR'][] = array('Product.id' => $product['Product']['parent_id']);
        }

        // Products in the same categories
        // Get category IDs in an array
        $categoryIds = Set::extract($product['Category'], '{n}.id');

        $conditionsSubQuery['category_id IN(?)'] = implode(',', $categoryIds);

        $db = $this->getDataSource();
        $subQuery = $db->buildStatement(
                array(
            'fields' => array('product_id'),
            'table' => 'categories_products',
            'joins' => array(),
            'alias' => 'c_p',
            'conditions' => $conditionsSubQuery,
            'order' => null,
            'group' => null,
            'limit' => null
                ), $this->CategoryProduct
        );
        $subQuery = 'Product.id IN (' . $subQuery . ') ';
        $subQueryExpression = $db->expression($subQuery);

        $conditions['OR'][] = $subQueryExpression;

        return $this->find('all', array(
                    'conditions' => $conditions,
                    'contain' => array('Category'),
                    'group' => 'Product.id',
                    'limit' => $limit
                ));
    }

    /**
     * Returns a product row from a slug.
     * @param string $slug
     */
    public function getBySlug($slug = null) {
        if (!$slug || empty($slug)) {
            return false;
        }

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

    /**
     * Updates a products total post
     * @param array $post Post data from $this->data
     */
    public function updateForumData($post) {

        // Find Product from thread
        $thread = $this->Thread->find('first', array(
            'conditions' => array('Thread.id' => $post['Post']['thread_id']),
            'fields' => 'product_id',
            'contain' => false
                ));

        $this->id = $thread['Thread']['product_id'];

        // Update Total post count
        $postData = $this->Thread->find('all', array(
            'fields' => array('SUM(Thread.post_count) AS total'),
            'conditions' => array(
                'Thread.product_id' => $this->id
            ),
            'contain' => false
                ));

        $this->save(array(
            'last_post_id' => $post['Post']['id'],
            'last_post_date' => date('Y-m-d H:i:s'),
            'post_count' => $postData[0][0]['total']
        ));
    }

}
