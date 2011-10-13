<?php

class NewsFixture extends CakeTestFixture {
	
	public $import = array('model' => 'News');
	
	public $records = array(
		array(
			'id' => 'news-1',
			'product_id' => 'product-1',
			'slug' => 'slug-1',
			'user_id' => 'user-1',
			'title' => 'News Article Number 1',
			'content' => 'Here is the content of news article number 1.',
			'source' => 'Source of news 1',
			'published' => 1,
			'deleted' => 0,
			'created' => '2011-09-23 12:12:12',
			'modified' => '2011-09-23 12:45:12'
		),
		array(
			'id' => 'news-2',
			'product_id' => 'product-2',
			'slug' => 'slug-2',
			'user_id' => 'user-2',
			'title' => 'News Article Number 2',
			'content' => 'Here is the content of news article number 2.',
			'source' => 'Source of news 2',
			'published' => 2,
			'deleted' => 0,
			'created' => '2022-09-23 22:22:22',
			'modified' => '2022-09-23 22:45:22'
		),
		array(
			'id' => 'news-3',
			'product_id' => 'product-1',
			'slug' => 'slug-2',
			'user_id' => 'user-2',
			'title' => 'News Article Number 3',
			'content' => 'Here is the content of news article number 3.',
			'source' => 'Source of news 3',
			'published' => 1,
			'deleted' => 0,
			'created' => '2011-09-26 12:12:12',
			'modified' => '2011-09-26 12:45:12'
		),
		
	);
}