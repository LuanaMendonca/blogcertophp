<?php
/**
 * User Fixture
 */
class UserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100),
		'email' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150),
		'password' => array('type' => 'string', 'null' => false, 'default' => null),
		'role' => array('type' => 'string', 'null' => true, 'default' => 'author', 'length' => 20),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'email' => array('unique' => true, 'column' => 'email')
		),
		'tableParameters' => array()
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'email' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'role' => 'Lorem ipsum dolor ',
			'created' => '2026-07-22 19:08:38',
			'modified' => '2026-07-22 19:08:38'
		),
	);

}
