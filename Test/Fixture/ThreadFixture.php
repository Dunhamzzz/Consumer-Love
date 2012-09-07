<?php

/* Thread Fixture generated on: 2011-09-06 22:35:38 : 1315348538 */

/**
 * ThreadFixture
 *
 */
class ThreadFixture extends CakeTestFixture {

    /**
     * Fields
     *
     * @var array
     */
    public $fields = array(
        'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
        'product_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
        'user_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
        'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
        'slug' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 150, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
        'deleted' => array('type' => 'boolean', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
        'first_post_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
        'last_post_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
        'last_user_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
        'last_post_date' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
        'post_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'collate' => NULL, 'comment' => ''),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'product_id' => array('column' => 'product_id', 'unique' => 0), 'user_id' => array('column' => 'user_id', 'unique' => 0), 'slug' => array('column' => 'slug', 'unique' => 0)),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );

    /**
     * Records
     *
     * @var array
     */
    public $records = array(
        array(
            'id' => 'thread-1',
            'product_id' => 'product-1',
            'user_id' => 'user-1',
            'title' => 'Can\'t knock it',
            'slug' => 'cantknockit',
            'deleted' => 0,
            'first_post_id' => 'post-1',
            'last_post_id' => 'post-4',
            'last_user_id' => 'user-1',
            'last_post_date' => '2012-05-06 13:13:13',
            'post_count' => '3',
            'created' => '2011-09-05 20:55:03',
            'modified' => '2011-09-05 20:55:03'
        ),
        array(
            'id' => 'thread-2',
            'product_id' => 'product-2',
            'user_id' => 'user-1',
            'title' => 'Can\'t knock it til I tried it',
            'slug' => 'cantknockit-til-i-tried-it',
            'deleted' => 0,
            'first_post_id' => 'post-3',
            'last_post_id' => 'post-3',
            'last_user_id' => 'user-1',
            'last_post_date' => '2012-05-08 22:12:44',
            'post_count' => '1',
            'created' => '2011-09-05 20:55:03',
            'modified' => '2011-09-05 20:55:03'
        ),
    );

}
