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
		'parent_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			)
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		)
	);
	
	public $hasAndBelongsToMany = array('Product' => array('counterCache' => true));
	
	public function search($term, $limit = 10) {
		// Prevent wildcard searches
		$term = str_replace('%', ' ', $term);
		
		return $this->find('all', array(
				'conditions' => array(
					'Category.name LIKE ?' => '%'.$term.'%'
				),
				'fields' => array('name', 'id', 'slug'),
				'limit' => $limit,
				'order' => 'Category.name',
				'contain' => false
			));
	}
}