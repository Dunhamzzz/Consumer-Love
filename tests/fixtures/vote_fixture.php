<?php
/* Vote Fixture generated on: 2011-02-08 19:51:18 : 1297194678 */
class VoteFixture extends CakeTestFixture {
	var $name = 'Vote';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'product_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'score' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'comment' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'product_id' => 1,
			'score' => 1,
			'comment' => 'Lorem ipsum dolor sit amet',
			'created' => '2011-02-08 19:51:18',
			'modified' => '2011-02-08 19:51:18'
		),
	);
}
?>