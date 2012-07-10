<?php

/* CategoriesProduct Fixture generated on: 2011-09-05 20:01:20 : 1315252880 */

/**
 * CategoriesProductFixture
 *
 */
class CategoriesProductFixture extends CakeTestFixture {

    /**
     * Fields
     *
     * @var array
     */
    public $fields = array(
        'product_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
        'category_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
        'indexes' => array('product_id' => array('column' => array('product_id', 'category_id'), 'unique' => 0)),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );

    /**
     * Records
     *
     * @var array
     */
    public $records = array(
        array(
            'product_id' => 'product-1',
            'category_id' => '1'
        ),
        array(
            'product_id' => 'product-2',
            'category_id' => '1'
        ),
        array(
            'product_id' => 'product-3',
            'category_id' => '1'
        ),
        array(
            'product_id' => 'product-1',
            'category_id' => '2'
        ),
        array(
            'product_id' => 'product-4',
            'category_id' => '3'
        ),
        array(
            'product_id' => 'product-5',
            'category_id' => '4'
        ),
        array(
            'product_id' => 'product-5',
            'category_id' => '5'
        ),
    );

}
