<?php
// Usercontroller controla tudo que o usuario pode fazer dentro do sistema
// serve também para decidir o que deve ser feito, recebe as ações e decide o que deve acontecer
// é o intermediario entre as telas de usuario e o banco de dados

App::uses('AppController', 'Controller');

class UsersController extends AppController
{
	public function beforeFilter(){

		parent::beforeFilter();

		$this->Auth->allow('add', 'login');

		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->Session->write('Auth.User', $this->request->data);
			}


		}
	}
}
