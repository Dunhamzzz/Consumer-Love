<?php

/* Thread Test cases generated on: 2011-09-06 22:34:36 : 1315348476 */
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
     * @covers Thread::add
     */
    public function testAdd_noData_expectsFalse()
    {
        // Test No Data
        $thread = $this->Thread->add(null);
        $this->assertFalse($thread, 'Thread was added when it contained no data.');

    }

    /**
     * @covers Thread::add
     */
    public function testAdd_emptyData_expectsFalse()
    {
        // Test Empty Title/Content/ProductID/UserID
        $data = array('Thread' => array(
            'title' => '',
            'content' => '',
            'product_id' => '',
            'user_id' => ''
        ));
        $threadAdded = $this->Thread->add($data);
        $this->assertFalse($threadAdded, 'Thread was added with empty details.');

        // Check The Invalid Fields
        $this->assertEquals(array('title', 'content', 'product_id', 'user_id'), array_keys($this->Thread->invalidFields()), 'Invalid invalidFields');
    }

    /**
     * @covers Thread::add
     */
    public function testAdd_validData_expectsThreadSlug()
    {
        $data = array(
            'Thread' => array(
                'product_id' => '4dde9f7a-01f8-495d-90b4-55c06d4ac163',
                'title' => 'Here is a thread title',
                'content' => 'Here is a thread post body.',
                'user_id' => '4dde9f7a-01f8-495d-90b4-55c06d4ac163',
                'user_ip' => '123.123.123.123'
            )
        );

        $thread = $this->Thread->add($data);
        $this->assertTrue(strlen($thread) == 22, 'Failed getting expected thread slug after save.');
        // Get latest thread to check this is it
        $latestThread = $this->Thread->find('first', array('order' => 'created DESC', 'contain' => false));
        $this->assertEquals($data['Thread']['title'], $latestThread['Thread']['title'], 'Thread title not as expected');
        $this->assertEquals($data['Thread']['user_id'], $latestThread['Thread']['user_id'], 'Thread was assigned to wrong user');
        $this->assertEquals($data['Thread']['product_id'], $latestThread['Thread']['product_id'], 'Thread was assigned to wrong product.');
    }

    /**
     * testGetBySlug method
     *
     * @covers Thread::getBySlug
     */
    public function testGetBySlug() {
        $this->assertEquals($this->Thread->getBySlug('invalidslug'), false, 'Invalid thread slug returned a result');
        $this->assertEquals($this->Thread->getBySlug('invalidslug', 'product-1'), false, 'Invalid thread slug w/ valid product returned a result');

        $expectedThread = $this->Thread->find('first', array(
            'conditions' => array('Thread.id' => 'thread-1'),
            'contain' => array('Product', 'User', 'FirstPost')
        ));


        $this->assertEquals($this->Thread->getBySlug('cantknockit'), $expectedThread);
        $this->assertEquals($this->Thread->getBySlug('cantknockit', 'product-1'), $expectedThread);

        $this->assertEquals($this->Thread->getBySlug('cantknockit', 'invalidproduct'), false);

    }

    /**
     * @covers getLatestByProductId
     */
    public function testGetLatestByProductId_noProductId_expectsEmptyArray()
    {
        $this->assertEquals(array(), $this->Thread->getLatestByProductId());
    }

    /**
     * @covers getLatestByProductId
     */
    public function testGetLatestByProductId_validProductId_expectsArray()
    {
        $threads = $this->Thread->getLatestByProductId('product-1');

        $this->assertEquals(count($threads), 2);
    }

     /**
     * @covers getLatestByProductId
     */
    public function testGetLatestByProductId_limit1_expectsArray()
    {
        $threads = $this->Thread->getLatestByProductId('product-1', 1);

        $this->assertEquals(count($threads), 1);
    }
}
