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
     * testAdd method
     * 
     * @covers Thread::add
     *
     */
    public function testAdd() {
        
        // Test No Data
        $data = null;
        $thread = $this->Thread->add($data);
        $this->assertFalse($thread, 'Thread was added when it contained no data.');
        
        // Test Empty Title/Content/ProductID/UserID
        $data = array('Thread' => array(
            'title' => '',
            'content' => '',
            'product_id' => '',
            'user_id' => ''
        ));
        $thread = $this->Thread->add($data);
        $this->assertFalse($thread, 'Thread was added with empty details.');
        
        // Check The Invalid Fields
        $this->assertEquals(array('title', 'content', 'product_id', 'user_id'), array_keys($this->Thread->invalidFields()), 'Invalid invalidFields');
        
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
        $this->assertTrue(strlen($thread) == 36, 'Failed getting UUID of thread after save.');
        // Get latest thread to check this is it
        $latestThread = $this->Thread->find('first', array('order' => 'created DESC', 'contain' => false));
        $this->assertEquals($data['Thread']['title'], $latestThread['Thread']['title']);
        $this->assertEquals($data['Thread']['user_id'], $latestThread['Thread']['user_id']);
        $this->assertEquals($data['Thread']['product_id'], $latestThread['Thread']['product_id']);
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
     * testGetForReply method
     *
     * @return void
     */
    public function testGetForReply() {
        
    }

}
