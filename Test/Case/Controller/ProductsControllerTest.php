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

    public function testView_validSlug_expectsHtml()
    {
        $html = $this->testAction('/products/view/product1', array('return' => 'contents'));

        $matcher = array(
            'tag' => 'h1',
            'content' => 'Product1'
        );

        // Check for <h1>Product Name</h1>
        $this->assertTag($matcher, $html, 'Title tag not found in view page');
    }

}