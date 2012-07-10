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
    );

}
