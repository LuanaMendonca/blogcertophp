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

	public function index(){

		$usuarioLogado = $this->Auth->user();

		if ($usuarioLogado['role'] != 'superadmin') {
			throw new ForbiddenException(
				'Somente o superadministrador pode visualizar os usuários.'
			);
		}

		$usuarios = $this->User->find('all');

		$this->set('usuarios', $usuarios);
	}
	public function edit($id = null)
	{
		if (!$id) {
			throw new NotFoundException('Usuário não encontrado.');
		}

		$usuario = $this->User->findById($id);

		if (!$usuario) {
			throw new NotFoundException('Usuário não encontrado.');
		}

		$usuarioLogado = $this->Auth->user();

		if ($usuarioLogado['role'] != 'superadmin') {
			throw new ForbiddenException(
				'Somente o superadministrador pode editar usuários.'
			);
		}

		if ($this->request->is(array('post', 'put'))) {

			$this->User->id = $id;

			if ($this->User->save($this->request->data)) {

				$this->Session->setFlash('Usuário editado com sucesso.');

				return $this->redirect(
					array(
					'action' => 'index')
				);
			} else {
				$this->Session->setFlash('Erro ao editar o usuário.');
			}
		} else {
			$this->request->data = $usuario;
		}
	}
	public function logout()
	{
		$this->Auth->logout();

		$this->Session->setFlash('Você saiu da sua conta.');
		return $this->redirect('/posts/visitas');
	}
}
