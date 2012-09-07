<?php
/**
 * Test Case for the products controller
 */

class ProductsControllerTest extends ControllerTestCase
{

    public $fixtures = array(
        'app.product',
        'app.category',
        'app.inventory',
        'app.categories_product',
        'app.thread',
        'app.post',
        'app.user',
        'app.news'
    );

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @covers ProductsController::view
     * @expectedException NotFoundException
     * @expectedExceptionMessage Invalid Product
     */
    public function testView_noSlugPassed_expectsException()
    {
        $this->testAction('/products/view/');
    }

    /**
     * @covers ProductsController::view
     * @expectedException NotFoundException
     * @expectedExceptionMessage Invalid Product
     */
    public function testView_invalidSlugPassed_expectsException()
    {
        $this->testAction('/products/view/invalid');
    }

    /**
     * @covers ProductsController::view
     */
    public function testView_validSlug_expectsHtml()
    {
        $html = $this->testAction('/products/view/product1', array('return' => 'contents'));

        $matcher = array(
            'tag' => 'h1',
            'content' => 'Product 1'
        );

        // Check for <h1>Product Name</h1>
        $this->assertTag($matcher, $html, 'Title tag not found in view page');
    }

    /**
     * @covers ProductsController::view
     */
    public function testView_validSlug_expectsViewVars()
    {
        $viewVars = $this->testAction('/products/view/product1', array('return' => 'vars'));

        $this->assertTrue(array_key_exists('product', $viewVars), 'No $product passed to view');
        $this->assertTrue(array_key_exists('title_for_layout', $viewVars), 'No $title_for_layout passed to view');
        $this->assertTrue(array_key_exists('canonical', $viewVars), 'No $canonical passed to view');
        $this->assertTrue(array_key_exists('threads', $viewVars), 'No $thread passed to view');
        $this->assertTrue(array_key_exists('news', $viewVars), 'No $news passed to view');
        $this->assertTrue(array_key_exists('related', $viewVars), 'No $related passed to view');
    }

}