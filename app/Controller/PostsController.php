<?php

App::uses('AppController', 'Controller');

class PostsController extends AppController
{
	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow('visitas', 'view');
	}

	public function visitas()
	{
		$posts = $this->Post->find(
			'all',
			array(
				'conditions' => array(
					'Post.status' => 'ativo'
				),
				'order' => array(
					'Post.created' => 'DESC'
				)
			)
		);

		$this->set('posts', $posts);
	}

	public function add()
	{
		if ($this->request->is('post')) {
			$this->Post->create();

			$this->request->data['Post']['user_id'] =
				$this->Auth->user('id');

			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash(
					'Postagem cadastrada com sucesso.'
				);

				return $this->redirect(
					array(
						'action' => 'index'
					)
				);
			}

			$this->Session->setFlash(
				'Não foi possível cadastrar a postagem.'
			);
		}
	}

	public function index()
	{
		$conditions = array();
		$usuarioId = $this->Auth->user('id');

		$busca = $this->request->query('busca');
		$status = $this->request->query('status');
		$dataInicial = $this->request->query('data_inicial');
		$dataFinal = $this->request->query('data_final');

		$conditions['AND'] = array(
			array(
				'OR' => array(
					array(
						'Post.status' => 'ativo'
					),
					array(
						'Post.status' => 'inativo',
						'Post.user_id' => $usuarioId
					)
				)
			)
		);

		if (
			!empty($status) &&
			in_array($status, array('ativo', 'inativo'))
		) {
			$conditions['AND'][] = array(
				'Post.status' => $status
			);
		}

		if (!empty($busca)) {
			$conditions['AND'][] = array(
				'OR' => array(
					'Post.titulo ILIKE' => '%' . $busca . '%',
					'Post.conteudo ILIKE' => '%' . $busca . '%'
				)
			);
		}

		if (!empty($dataInicial)) {
			$conditions['AND'][] = array(
				'Post.created >=' => $dataInicial . ' 00:00:00'
			);
		}

		if (!empty($dataFinal)) {
			$conditions['AND'][] = array(
				'Post.created <=' => $dataFinal . ' 23:59:59'
			);
		}

		$posts = $this->Post->find(
			'all',
			array(
				'conditions' => $conditions,
				'order' => array(
					'Post.created' => 'DESC'
				)
			)
		);

		$this->set('posts', $posts);
	}

	public function view($id = null)
	{
		if (!$id) {
			throw new NotFoundException(
				'Postagem não encontrada.'
			);
		}

		$post = $this->Post->findById($id);

		if (!$post) {
			throw new NotFoundException(
				'Postagem não encontrada.'
			);
		}

		$usuarioId = $this->Auth->user('id');

		$ehDono =
			!empty($usuarioId) &&
			$usuarioId == $post['Post']['user_id'];

		$ehRascunho =
			$post['Post']['status'] === 'inativo';

		if ($ehRascunho && !$ehDono) {
			throw new NotFoundException(
				'Postagem não encontrada.'
			);
		}

		$this->set('post', $post);
	}

	public function edit($id = null)
	{
		if (!$id) {
			throw new NotFoundException(
				'Post não encontrado.'
			);
		}

		$post = $this->Post->findById($id);

		if (!$post) {
			throw new NotFoundException(
				'Post não encontrado.'
			);
		}

		$usuario = $this->Auth->user();

		$ehDono =
			$usuario['id'] == $post['Post']['user_id'];

		$ehAdministrador =
			$usuario['role'] === 'admin' ||
			$usuario['role'] === 'superadmin';

		$ehRascunho =
			$post['Post']['status'] === 'inativo';

		if ($ehRascunho && !$ehDono) {
			throw new ForbiddenException(
				'Você não tem permissão para editar este rascunho.'
			);
		}

		if (
			!$ehRascunho &&
			!$ehDono &&
			!$ehAdministrador
		) {
			throw new ForbiddenException(
				'Você não tem permissão para editar esta postagem.'
			);
		}

		$this->set('post', $post);

		if ($this->request->is(array('post', 'put'))) {
			$this->Post->id = $id;

			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash(
					'Post editado com sucesso.'
				);

				return $this->redirect(
					array(
						'action' => 'index'
					)
				);
			}

			$this->Session->setFlash(
				'Erro ao editar o post.'
			);
		} else {
			$this->request->data = $post;
		}
	}

	public function delete($id = null)
	{
		$this->request->allowMethod('post');

		if (!$id) {
			throw new NotFoundException(
				'Post não encontrado.'
			);
		}

		$post = $this->Post->findById($id);

		if (!$post) {
			throw new NotFoundException(
				'Post não encontrado.'
			);
		}

		$usuario = $this->Auth->user();

		if (
			$usuario['role'] != 'superadmin' &&
			$usuario['role'] != 'admin' &&
			$usuario['id'] != $post['Post']['user_id']
		) {
			throw new ForbiddenException(
				'Você não pode excluir esta postagem.'
			);
		}

		$this->Post->id = $id;

		if ($this->Post->delete()) {
			$this->Session->setFlash(
				'Post excluído.'
			);

			return $this->redirect(
				array(
					'action' => 'index'
				)
			);
		}

		$this->Session->setFlash(
			'Erro ao excluir o post.'
		);

		return $this->redirect(
			array(
				'action' => 'index'
			)
		);
	}
}
