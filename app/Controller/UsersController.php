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
	}
	public function login(){
		if ($this->request->is('post')) {

			if ($this->Auth->login()) {
				//login deu certo
				return $this->redirect(
					array(
						'controller' => 'posts',
						'action' => 'index'
					)
				);
			}
			else{
				//login deu errado
				$this->Session->setFlash('Usuário ou senha inválidos.');
			}
		}
	}
}
