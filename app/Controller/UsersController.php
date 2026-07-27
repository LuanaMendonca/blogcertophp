<?php

// UsersController controla as ações relacionadas aos usuários.
// Ele recebe as ações das telas e decide o que deve acontecer.

App::uses('AppController', 'Controller');

class UsersController extends AppController
{
	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow('add', 'login');
	}

	public function login()
	{
		if ($this->request->is('post')) {

			if ($this->Auth->login()) {

				// Login deu certo
				$this->Session->setFlash('Login realizado com sucesso.');

				return $this->redirect(
					array(
						'controller' => 'posts',
						'action' => 'index'
					)
				);

			} else {

				// Login deu errado
				$this->Session->setFlash('Usuário ou senha inválidos.');
			}
		}
	}
	public function add()
	{
		if ($this->request->is('post')) {

			$this->User->create();
			$data = $this->request->data;
			$data['User']['role'] = 'author';

			if ($this->User->save($data)) {

				$this->Session->setFlash('Usuário criado com sucesso.');

				return $this->redirect(
					array(
						'action' => 'login'
					)
				);
			} else {

				$this->Session->setFlash('Erro ao criar usuário.');
			}
		}
	}
}
