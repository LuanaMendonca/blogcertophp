<?php

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
				$this->Session->setFlash(
					'Login realizado com sucesso.',
					'default',
					array(
						'class' => 'flash-message flash-success'
					)
				);

				return $this->redirect(
					array(
						'controller' => 'posts',
						'action' => 'index'
					)
				);
			}

			$this->Session->setFlash(
				'Usuário ou senha inválidos.',
				'default',
				array(
					'class' => 'flash-message flash-error'
				)
			);
		}
	}

	public function add()
	{
		if ($this->request->is('post')) {
			$this->User->create();

			$data = $this->request->data;
			$data['User']['role'] = 'author';

			if ($this->User->save($data)) {
				$this->Session->setFlash(
					'Usuário criado com sucesso.',
					'default',
					array(
						'class' => 'flash-message flash-success'
					)
				);

				return $this->redirect(
					array(
						'action' => 'login'
					)
				);
			}

			$this->Session->setFlash(
				'Erro ao criar usuário.',
				'default',
				array(
					'class' => 'flash-message flash-error'
				)
			);
		}
	}

	public function index()
	{
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
			if (empty($this->request->data['User']['password'])) {
				unset($this->request->data['User']['password']);
			}

			if (empty($this->request->data['User']['username'])) {
				unset($this->request->data['User']['username']);
			}

			$this->User->id = $id;

			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(
					'Usuário editado com sucesso.',
					'default',
					array(
						'class' => 'flash-message flash-success'
					)
				);

				return $this->redirect(
					array(
						'action' => 'index'
					)
				);
			}

			$this->Session->setFlash(
				'Erro ao editar o usuário.',
				'default',
				array(
					'class' => 'flash-message flash-error'
				)
			);
		} else {
			$this->request->data = $usuario;
		}
	}

	public function logout()
	{
		$this->Auth->logout();

		$this->Session->setFlash(
			'Você saiu da sua conta.',
			'default',
			array(
				'class' => 'flash-message flash-success'
			)
		);

		return $this->redirect('/posts/visitas');
	}

	public function delete($id = null)
	{
		$this->request->onlyAllow('post', 'delete');

		$usuarioLogado = $this->Auth->user();

		if (empty($usuarioLogado)) {
			return $this->redirect(array('action' => 'login'));
		}

		$this->User->id = $id;

		if (!$this->User->exists()) {
			throw new NotFoundException('Usuário não encontrado.');
		}

		$usuarioExcluido = $this->User->findById($id);

		$perfilLogado = $usuarioLogado['role'];
		$perfilUsuario = $usuarioExcluido['User']['role'];

		$ehPropriaConta =
			(int)$usuarioLogado['id'] ===
			(int)$usuarioExcluido['User']['id'];

		$podeExcluir = false;

		if ($ehPropriaConta) {
			$podeExcluir = true;
		}

		if (
			$perfilLogado === 'admin' &&
			$perfilUsuario === 'author'
		) {
			$podeExcluir = true;
		}

		if ($perfilLogado === 'superadmin') {
			$podeExcluir = true;
		}

		if (!$podeExcluir) {
			$this->Session->setFlash(
				'Você não tem permissão para excluir este usuário.',
				'default',
				array(
					'class' => 'flash-message flash-error'
				)
			);

			return $this->redirect(
				array(
					'action' => 'index'
				)
			);
		}

		if ($this->User->delete($id, true)) {
			if ($ehPropriaConta) {
				$this->Auth->logout();

				$this->Session->setFlash(
					'Sua conta e suas postagens foram excluídas.',
					'default',
					array(
						'class' => 'flash-message flash-success'
					)
				);

				return $this->redirect(
					array(
						'controller' => 'posts',
						'action' => 'visitas'
					)
				);
			}

			$this->Session->setFlash(
				'Usuário e suas postagens foram excluídos com sucesso.',
				'default',
				array(
					'class' => 'flash-message flash-success'
				)
			);
		} else {
			$this->Session->setFlash(
				'Não foi possível excluir o usuário.',
				'default',
				array(
					'class' => 'flash-message flash-error'
				)
			);
		}

		return $this->redirect(
			array(
				'action' => 'index'
			)
		);
	}

	public function minhaConta()
	{
		$id = $this->Auth->user('id');

		$this->User->id = $id;

		if (!$this->User->exists()) {
			throw new NotFoundException('Usuário não encontrado.');
		}

		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['User']['id'] = $id;

			unset($this->request->data['User']['role']);

			if (empty($this->request->data['User']['password'])) {
				unset($this->request->data['User']['password']);
			}

			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(
					'Conta atualizada com sucesso.',
					'default',
					array(
						'class' => 'flash-message flash-success'
					)
				);

				return $this->redirect(
					array(
						'action' => 'minhaConta'
					)
				);
			}

			$this->Session->setFlash(
				'Não foi possível atualizar a conta.',
				'default',
				array(
					'class' => 'flash-message flash-error'
				)
			);
		} else {
			$this->request->data = $this->User->findById($id);

			unset($this->request->data['User']['password']);
		}
	}
}
