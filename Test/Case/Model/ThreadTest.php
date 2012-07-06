<?php
/* Thread Test cases generated on: 2011-09-06 22:34:36 : 1315348476*/
App::uses('Thread', 'Model');

/**
 * Thread Test Case
 *
 */
class ThreadTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.thread', 'app.post', 'app.user', 'app.inventory', 'app.product', 'app.news', 'app.category', 'app.categories_product');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Thread = ClassRegistry::init('Thread');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Thread);
		ClassRegistry::flush();

		parent::tearDown();
	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {

	}

/**
 * testGetBySlug method
 *
 * @return void
 */
	public function testGetBySlug() {

	}

/**
 * testGetForReply method
 *
 * @return void
 */
	public function testGetForReply() {

	}

}
