<?php
App::uses('CakeSchema', 'Model');

class AppSchema extends CakeSchema {

	public $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'length' => 100, 'null' => false),
		'email' => array('type' => 'string', 'length' => 150, 'null' => false),
		'password' => array('type' => 'string', 'length' => 255, 'null' => false),
		'role' => array('type' => 'string', 'length' => 20, 'default' => 'author'),
		'created' => array('type' => 'datetime'),
		'modified' => array('type' => 'datetime'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'email' => array('column' => 'email', 'unique' => 1)
		),
		'tableParameters' => array()
	);

	public $posts = array(
		'id' => array('type' => 'integer', 'null' => false, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false),
		'title' => array('type' => 'string', 'length' => 200, 'null' => false),
		'content' => array('type' => 'text', 'null' => false),
		'created' => array('type' => 'datetime'),
		'modified' => array('type' => 'datetime'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id')
		),
		'tableParameters' => array()
	);

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}
}
