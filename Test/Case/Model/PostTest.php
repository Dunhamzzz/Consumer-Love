<?php
/* Post Test cases generated on: 2011-09-06 22:35:09 : 1315348509*/
App::uses('Post', 'Model');

/**
 * Post Test Case
 *
 */
class PostTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.post', 'app.thread', 'app.product', 'app.user', 'app.report');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Post = ClassRegistry::init('Post');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Post);
		ClassRegistry::flush();

		parent::tearDown();
	}

/**
 * testAddFirst method
 *
 * @return void
 */
	public function testAddFirst() {

	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {

	}

/**
 * testGetLatest method
 *
 * @return void
 */
	public function testGetLatest() {

	}

}
