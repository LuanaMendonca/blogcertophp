<?php

App::uses('Controller', 'Controller');

class AppController extends Controller
{
	public $components = array(
		'Session',

		'Auth' => array(
			'loginAction' => array(
				'controller' => 'users',
				'action' => 'login'
			),

			'loginRedirect' => array(
				'controller' => 'posts',
				'action' => 'index'
			),

			'logoutRedirect' => array(
				'controller' => 'users',
				'action' => 'login'
			),

			'authError' => 'Você não tem permissão para acessar esta página.',

			'authenticate' => array(
				'Form' => array(
					'fields' => array(
						'username' => 'username',
						'password' => 'password'
					)
				)
			),

			'authorize' => array('Controller')
		)
	);

	public $helpers = array(
		'Html',
		'Form',
		'Session'
		'abstract '
	);

	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow('display');

		$this->set('authUser', $this->Auth->user());
	}

	public function isAuthorized($user)
	{
		return !empty($user);
	}
}
