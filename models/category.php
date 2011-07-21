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
	
}