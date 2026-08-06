<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController
{
	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow(
			'add',
			'login'
		);
	}

	public function login()
	{
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->Session->setFlash(
					'Login realizado com sucesso.',
					'default',
					array(
						'class' =>
							'flash-message flash-success'
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
					'class' =>
						'flash-message flash-error'
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
						'class' =>
							'flash-message flash-success'
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
					'class' =>
						'flash-message flash-error'
				)
			);
		}
	}

	public function index()
	{
		$usuarioLogado = $this->Auth->user();

		$ehAdministrador =
			$usuarioLogado['role'] === 'admin';

		$ehSuperadministrador =
			$usuarioLogado['role'] === 'superadmin';

		if (
			!$ehAdministrador &&
			!$ehSuperadministrador
		) {
			throw new ForbiddenException(
				'Você não tem permissão para visualizar os usuários.'
			);
		}

		$conditions = array();

		if ($ehAdministrador) {
			$conditions['User.role'] = 'author';
		}

		$usuarios = $this->User->find(
			'all',
			array(
				'conditions' => $conditions,
				'order' => array(
					'User.username' => 'ASC'
				)
			)
		);

		$this->set('usuarios', $usuarios);
	}

	public function edit($id = null)
	{
		if (!$id) {
			throw new NotFoundException(
				'Usuário não encontrado.'
			);
		}

		$usuario = $this->User->findById($id);

		if (!$usuario) {
			throw new NotFoundException(
				'Usuário não encontrado.'
			);
		}

		$usuarioLogado = $this->Auth->user();

		$ehAdministrador =
			$usuarioLogado['role'] === 'admin';

		$ehSuperadministrador =
			$usuarioLogado['role'] === 'superadmin';

		$usuarioEhAutor =
			$usuario['User']['role'] === 'author';

		$podeEditar =
			$ehSuperadministrador ||
			(
				$ehAdministrador &&
				$usuarioEhAutor
			);

		if (!$podeEditar) {
			throw new ForbiddenException(
				'Você não tem permissão para editar este usuário.'
			);
		}

		$podeAlterarPerfil =
			$ehSuperadministrador;

		$this->set(
			compact(
				'usuario',
				'podeAlterarPerfil'
			)
		);

		if (
			$this->request->is(
				array(
					'post',
					'put'
				)
			)
		) {
			if (
				empty(
				$this->request->data[
				'User'
				]['password']
				)
			) {
				unset(
					$this->request->data[
					'User'
					]['password']
				);

				unset(
					$this->request->data[
					'User'
					]['confirmPassword']
				);
			}

			if ($ehAdministrador) {
				$this->request->data[
				'User'
				]['role'] = 'author';
			}

			$this->User->id = $id;

			if (
				$this->User->save(
					$this->request->data
				)
			) {
				if (
					(int)$usuarioLogado['id'] ===
					(int)$id
				) {
					$this->Session->write(
						'Auth.User.username',
						$this->request->data[
						'User'
						]['username']
					);

					if (
						isset(
							$this->request->data[
							'User'
							]['role']
						)
					) {
						$this->Session->write(
							'Auth.User.role',
							$this->request->data[
							'User'
							]['role']
						);
					}
				}

				$this->Session->setFlash(
					'Usuário editado com sucesso.',
					'default',
					array(
						'class' =>
							'flash-message flash-success'
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
					'class' =>
						'flash-message flash-error'
				)
			);
		} else {
			unset(
				$usuario['User']['password']
			);

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
				'class' =>
					'flash-message flash-success'
			)
		);

		return $this->redirect(
			array(
				'controller' => 'posts',
				'action' => 'index'
			)
		);
	}

	public function delete($id = null)
	{
		$this->request->onlyAllow(
			'post',
			'delete'
		);

		$usuarioLogado = $this->Auth->user();

		if (empty($usuarioLogado)) {
			return $this->redirect(
				array(
					'action' => 'login'
				)
			);
		}

		$this->User->id = $id;

		if (!$this->User->exists()) {
			throw new NotFoundException(
				'Usuário não encontrado.'
			);
		}

		$usuarioExcluido =
			$this->User->findById($id);

		$perfilLogado =
			$usuarioLogado['role'];

		$perfilUsuario =
			$usuarioExcluido['User']['role'];

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
					'class' =>
						'flash-message flash-error'
				)
			);

			return $this->redirect(
				array(
					'controller' => 'posts',
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
						'class' =>
							'flash-message flash-success'
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
				'Usuário e suas postagens foram excluídos com sucesso.',
				'default',
				array(
					'class' =>
						'flash-message flash-success'
				)
			);
		} else {
			$this->Session->setFlash(
				'Não foi possível excluir o usuário.',
				'default',
				array(
					'class' =>
						'flash-message flash-error'
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

		$usuario = $this->User->findById($id);

		if (!$usuario) {
			throw new NotFoundException(
				'Usuário não encontrado.'
			);
		}

		$this->User->id = $id;

		if (
			$this->request->is(
				array(
					'post',
					'put'
				)
			)
		) {
			$this->request->data[
			'User'
			]['id'] = $id;

			unset(
				$this->request->data[
				'User'
				]['role']
			);

			if (
				empty(
				$this->request->data[
				'User'
				]['password']
				)
			) {
				unset(
					$this->request->data[
					'User'
					]['password']
				);

				unset(
					$this->request->data[
					'User'
					]['confirmPassword']
				);
			}

			if (
				$this->User->save(
					$this->request->data
				)
			) {
				$this->Session->write(
					'Auth.User.username',
					$this->request->data[
					'User'
					]['username']
				);

				$this->Session->setFlash(
					'Conta atualizada com sucesso.',
					'default',
					array(
						'class' =>
							'flash-message flash-success'
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
					'class' =>
						'flash-message flash-error'
				)
			);
		} else {
			unset(
				$usuario['User']['password']
			);

			$this->request->data = $usuario;
		}

		$this->set('usuario', $usuario);
	}
}
