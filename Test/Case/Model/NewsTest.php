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

    /**
     * @covers News::testSubmit
     */
    public function testSubmit() {

        // Submit some news with a too-short title and content
        $newsData = array(
            'News' => array(
                'title' => '2shrt',
                'content_raw' => 'Nada',
                'source' => 'News came from here',
                'product_id' => 'product-1'
            ),
        );
        
        $userData = array(
            'User' => array(
                'id' => 'user-1',
                'admin' => 1
            )
        );

        $news = $this->News->submit($newsData, $userData);
        $this->assertFalse($news);
        $this->assertEqual(array_keys($this->News->invalidFields()), array('title', 'content_raw'));

        // Succesfully Post Some News
        $postData = array(
            'News' => array(
                'title' => 'News Title, this is long enough',
                'content_raw' => 'Here is the news body',
                'source' => 'News came from here',
                'product_id' => 'product-1'
            )
        );

        $news = $this->News->submit($postData, $userData);

        $this->assertTrue(is_array($news));
        $this->assertTrue(array_key_exists('News', $news));

        $this->assertEqual($news['News']['user_id'], 'user-1');
    }

}