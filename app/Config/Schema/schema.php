<?php

App::uses('CakeSchema', 'Model');

class AppSchema extends CakeSchema
{
	public $users = array(
		'id' => array(
			'type' => 'integer',
			'null' => false,
			'key' => 'primary'
		),
		'username' => array(
			'type' => 'string',
			'length' => 100,
			'null' => false
		),
		'password' => array(
			'type' => 'string',
			'length' => 255,
			'null' => false
		),
		'role' => array(
			'type' => 'string',
			'length' => 20,
			'null' => false,
			'default' => 'author'
		),
		'created' => array('type' => 'datetime'),
		'modified' => array('type' => 'datetime'),
		'indexes' => array(
			'PRIMARY' => array(
				'column' => 'id',
				'unique' => 1
			),
			'username' => array(
				'column' => 'username',
				'unique' => 1
			)
		),
		'tableParameters' => array()
	);

	public $posts = array(
		'id' => array(
			'type' => 'integer',
			'null' => false,
			'key' => 'primary'
		),
		'user_id' => array(
			'type' => 'integer',
			'null' => false
		),
		'titulo' => array(
			'type' => 'string',
			'length' => 255,
			'null' => false
		),
		'conteudo' => array(
			'type' => 'text',
			'null' => false
		),
		'status' => array(
			'type' => 'string',
			'length' => 20,
			'null' => false,
			'default' => 'ativo'
		),
		'created' => array('type' => 'datetime'),
		'modified' => array('type' => 'datetime'),
		'indexes' => array(
			'PRIMARY' => array(
				'column' => 'id',
				'unique' => 1
			),
			'user_id' => array(
				'column' => 'user_id'
			)
		),
		'tableParameters' => array()
	);

	public function before($event = array())
	{
		return true;
	}

	public function after($event = array())
	{
	}
}
