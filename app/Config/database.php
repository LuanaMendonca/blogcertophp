<?php

class DATABASE_CONFIG
{
	public $default = array(
		'datasource' => 'Database/Postgres',
		'persistent' => false,
		'host' => 'db',
		'login' => 'luana_adm',
		'password' => 'luana1234',
		'database' => 'blog_cake2',
		'port' => '5432',
		'schema' => 'public',
		'prefix' => '',
		'encoding' => 'utf8'
	);

	public $test = array(
		'datasource' => 'Database/Postgres',
		'persistent' => false,
		'host' => 'db',
		'login' => 'blog_user',
		'password' => 'blog_senha',
		'database' => 'blog_cake2',
		'port' => '5432',
		'schema' => 'public',
		'prefix' => '',
		'encoding' => 'utf8'
	);
}
