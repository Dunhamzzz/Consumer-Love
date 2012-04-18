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
            'product_id' => '4dde9f7a-01f8-495d-90b4-55c06d4ac163',
            'category_id' => '32'
        ),
        array(
            'product_id' => '4dde9f7a-0690-462c-a94f-55c06d4ac163',
            'category_id' => '22'
        ),
        array(
            'product_id' => '4dde9f7a-0740-4b15-abe7-55c06d4ac163',
            'category_id' => '6'
        ),
        array(
            'product_id' => '4dde9f7a-07a8-449d-b738-55c06d4ac163',
            'category_id' => '36'
        ),
        array(
            'product_id' => '4dde9f7a-10ac-47de-8572-55c06d4ac163',
            'category_id' => '25'
        ),
        array(
            'product_id' => '4dde9f7a-1cb4-4f07-9b93-55c06d4ac163',
            'category_id' => '5'
        ),
        array(
            'product_id' => '4dde9f7a-21f8-471c-9c0f-55c06d4ac163',
            'category_id' => '16'
        ),
        array(
            'product_id' => '4dde9f7a-2758-462f-90f7-55c06d4ac163',
            'category_id' => '14'
        ),
        array(
            'product_id' => '4dde9f7a-2810-4ec9-a138-55c06d4ac163',
            'category_id' => '38'
        ),
        array(
            'product_id' => '4dde9f7a-2810-4ec9-a138-55c06d4ac163',
            'category_id' => '41'
        ),
    );

}
