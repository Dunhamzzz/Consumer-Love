<?php

class Category extends AppModel {

    public $actsAs = array(
        'Utils.Sluggable' => array(
            'label' => 'name',
            'method' => 'multibyteSlug',
            'separator' => '-'
        ),
        'Tree'
    );

    public $validate = array(
        'name' => array(
            'required_field' => array(
                'rule' => 'notEmpty',
                'allowEmpty' => false,
                'message' => 'Category must have a name!'
            ),
        )
    );

    public $hasAndBelongsToMany = array(
        'Product' => array('counterCache' => array('Product.published' => 1))
    );

    public function search($term, $limit = 10) {
        // Prevent wildcard searches
        $term = str_replace('%', ' ', $term);

        return $this->find('all', array(
                    'conditions' => array(
                        'Category.name LIKE ?' => '%' . $term . '%'
                    ),
                    'fields' => array('name', 'id', 'slug', 'product_count'),
                    'limit' => $limit,
                    'order' => 'Category.name',
                    'contain' => false
                ));
    }

}