<?php

/* Product Test cases generated on: 2011-09-05 19:35:19 : 1315251319 */
App::uses('Product', 'Model');

/**
 * Product Test Case
 *
 */
class ProductTestCase extends CakeTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array('app.product', 'app.inventory', 'app.user', 'app.category', 'app.categories_product');

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->Product = ClassRegistry::init('Product');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Product);
        ClassRegistry::flush();

        parent::tearDown();
    }

    /**
     * @covers Product::getBySlug
     */
    public function testGetBySlug_success_expectsArray()
    {
        $product = $this->Product->getBySlug('product1');
        $this->assertEquals(array('product-1'), Set::extract('/Product/id', $product));
    }

    /**
     * @covers Product::getBySlug
     */
    public function testGetBySlug_noParams_expectsFalse()
    {
        $this->assertFalse($this->Product->getBySlug());
    }

}
