<?php

App::uses('News', 'Model');

class NewsTestCase extends CakeTestCase {
	
	public $fixtures = array('app.product', 'app.news', 'app.user');
	
	public function setUp() {
		parent::setUp();

		$this->News = ClassRegistry::init('News');
	}

	public function tearDown() {
		unset($this->News);
		ClassRegistry::flush();

		parent::tearDown();
	}
	
	// Begin Model Tests
	public function testSubmit() {
		
		$postData = array(
			'News' => array(
				'title' => '2shrt',
				'body' => 'Here is the news body',
				'source' => 'News came from here',
				'product_id' => 'product-1'
			)
		);
		
		$news = $this->News->submit($postData, 'user-1');
		$this->assertFalse($news);
		$this->assertEqual(array_keys($this->News->invalidFields()), array('title'));
		
		$postData = array(
			'News' => array(
				'title' => 'News Title',
				'body' => 'Here is the news body',
				'source' => 'News came from here',
				'product_id' => 'product-1'
			)
		);
		
		$news = $this->News->submit($postData, 'user-1');
		
		$this->assertTrue(is_array($news));
		$this->assertTrue(array_key_exists('News', $news));
		
		$this->assertEqual($news['User']['id'], 'user-1');
	}
}