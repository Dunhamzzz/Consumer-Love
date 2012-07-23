<?php

App::uses( 'Post', 'Model' );

/**
 * Post Test Case
 *
 */
class PostTestCase extends CakeTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array( 'app.post', 'app.thread', 'app.product', 'app.user' );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->Post = ClassRegistry::init( 'Post' );
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset( $this->Post );
        ClassRegistry::flush();

        parent::tearDown();
    }

    /**
     * @covers Post::addFirst
     */
    public function testAddFirst()
    {
        
    }

    /**
     * testAdd method
     *
     * @return void
     */
    public function testAdd()
    {
        
    }

    /**
     * @covers Post::getLatest
     */
    public function testGetLatest()
    {
        $latest = $this->Post->getLatest();
        $this->assertEquals(5, count($latest));
        
        $limit = 5;
        $latest = $this->Post->getLatest($limit);
        $this->assertEquals($limit, count($latest), 'Number of latest Posts returned did not match parameter');
        
        // Order of Post IDs from new > old
        $expected = array('post-6', 'post-5', 'post-4', 'post-3.5', 'post-2');
        $this->assertEquals($expected, Set::extract('/Post/id', $latest), 'Latest posts do not match the expected.');
    }

    /**
     * @covers Post::getLatest
     * @expectedException DomainException
     * @expectedExceptionMessage Invalid value passed for limit.
     */
    public function testGetLatest_InvalidLimit_ThrowsException()
    {
        $latest = $this->Post->getLatest('potato');
    }

}
