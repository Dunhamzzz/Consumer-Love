<?php

/* Category Fixture generated on: 2011-09-05 19:59:07 : 1315252747 */

/**
 * CategoryFixture
 *
 */
class CategoryFixture extends CakeTestFixture {

    /**
     * Fields
     *
     * @var array
     */
    public $fields = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
        'parent_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 10, 'key' => 'index', 'collate' => NULL, 'comment' => ''),
        'lft' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'collate' => NULL, 'comment' => ''),
        'rght' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'collate' => NULL, 'comment' => ''),
        'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
        'slug' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 60, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
        'description' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
        'product_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'collate' => NULL, 'comment' => ''),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'slug' => array('column' => 'slug', 'unique' => 1), 'parent_id' => array('column' => 'parent_id', 'unique' => 0), 'name' => array('column' => 'name', 'unique' => 0)),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );

    /**
     * Records
     *
     * @var array
     */
    public $records = array(
        array(
            'id' => '1',
            'parent_id' => '0',
            'lft' => '1',
            'rght' => '12',
            'name' => 'Gaming',
            'slug' => 'gaming',
            'description' => '',
            'product_count' => '0',
            'created' => '2011-02-08 20:01:32',
            'modified' => '2011-02-08 20:01:32'
        ),
        array(
            'id' => '3',
            'parent_id' => '1',
            'lft' => '2',
            'rght' => '3',
            'name' => 'PC',
            'slug' => 'pc',
            'description' => '',
            'product_count' => '0',
            'created' => '2011-02-08 20:20:31',
            'modified' => '2011-02-08 20:35:05'
        ),
        array(
            'id' => '4',
            'parent_id' => '0',
            'lft' => '13',
            'rght' => '28',
            'name' => 'Software',
            'slug' => 'software',
            'description' => '',
            'product_count' => '0',
            'created' => '2011-02-08 21:31:31',
            'modified' => '2011-02-08 21:31:31'
        ),
        array(
            'id' => '5',
            'parent_id' => '4',
            'lft' => '14',
            'rght' => '15',
            'name' => 'Media Players',
            'slug' => 'mediaplayers',
            'description' => '',
            'product_count' => '0',
            'created' => '2011-02-08 21:32:11',
            'modified' => '2011-02-09 12:40:07'
        ),
        array(
            'id' => '6',
            'parent_id' => '1',
            'lft' => '4',
            'rght' => '5',
            'name' => 'Xbox 360',
            'slug' => 'xbox360',
            'description' => '',
            'product_count' => '0',
            'created' => '2011-02-08 21:33:39',
            'modified' => '2011-02-08 21:33:39'
        ),
        array(
            'id' => '7',
            'parent_id' => '1',
            'lft' => '6',
            'rght' => '7',
            'name' => 'Playstation 3',
            'slug' => 'ps3',
            'description' => '',
            'product_count' => '0',
            'created' => '2011-02-08 21:34:21',
            'modified' => '2011-02-08 21:34:21'
        ),
        array(
            'id' => '8',
            'parent_id' => '0',
            'lft' => '29',
            'rght' => '36',
            'name' => 'Services',
            'slug' => 'services',
            'description' => '',
            'product_count' => '0',
            'created' => '2011-02-08 21:34:57',
            'modified' => '2011-02-08 21:34:57'
        ),
        array(
            'id' => '9',
            'parent_id' => '8',
            'lft' => '30',
            'rght' => '31',
            'name' => 'Broadband Providers',
            'slug' => 'broadband',
            'description' => '',
            'product_count' => '0',
            'created' => '2011-02-08 21:35:23',
            'modified' => '2011-02-08 21:35:23'
        ),
        array(
            'id' => '10',
            'parent_id' => '0',
            'lft' => '37',
            'rght' => '46',
            'name' => 'Computing',
            'slug' => 'computing',
            'description' => '',
            'product_count' => '0',
            'created' => '2011-02-08 21:35:41',
            'modified' => '2011-02-08 21:35:41'
        ),
        array(
            'id' => '11',
            'parent_id' => '10',
            'lft' => '38',
            'rght' => '39',
            'name' => 'Manufacturers',
            'slug' => 'manus',
            'description' => '',
            'product_count' => '0',
            'created' => '2011-02-08 21:35:53',
            'modified' => '2011-02-08 21:35:53'
        ),
    );

}
