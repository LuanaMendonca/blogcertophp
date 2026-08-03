<?php

App::uses('AppController', 'Controller');

class PostsController extends AppController
{
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('visitas');
	}
	public function visitas(){
		$posts = $this->Post->find(
			'all',
			array(
				'conditions' => array(
					'Post.status' => 'ativo'
				)
			)
		);
		$this->set('posts', $posts);
	}
	public function index()
	{
		$conditions = array();
		$usuarioId = $this->Auth->user('id');

		$busca = $this->request->query('busca');
		$status = $this->request->query('status');

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

		if (!empty($status) && in_array($status, array('ativo', 'inativo'))) {
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
	public function edit($id = null)
	{
		if (!$id) {
			throw new NotFoundException('Post não encontrado.');
		}

		$post = $this->Post->findById($id);

		$this->set('post', $post);

		if (!$post) {
			throw new NotFoundException('Post não encontrado.');
		}

		$usuario = $this->Auth->user();

		if ( $usuario['role'] != 'superadmin'
			&& $usuario['role'] != 'admin'
			&& $usuario['id'] != $post['Post']['user_id']) {
			throw new ForbiddenException('Você não tem permissão para editar esta postagem.');
		}

		if ($this->request->is(array('post', 'put'))) {

			$this->Post->id = $id;

			if ($this->Post->save($this->request->data)) {

				$this->Session->setFlash('Post editado com sucesso.');
				return $this->redirect(array('action' => 'index'));
			}

			$this->Session->setFlash('Erro ao editar o post.');
		}
		else {
			$this->request->data = $post;
		}
	}

	public function delete($id = null)
	{
		$this->request->allowMethod('post');

		if (!$id) {
			throw new NotFoundException('Post não encontrado.');
		}

		$post = $this->Post->findById($id);

		$usuario = $this->Auth->user();

		if (!$post) {
			throw new NotFoundException('Post não encontrado.');
		}

		if ($usuario['role'] != 'superadmin' &&
			$usuario['role'] != 'admin' &&
			$usuario['id'] != $post['Post']['user_id']) {

			throw new ForbiddenException('Você não pode excluir esta postagem.');
		}

		$this->Post->id = $id;

		if ($this->Post->delete()) {

			$this->Session->setFlash('Post excluído.');

			return $this->redirect(array('action' => 'index'));
		}

		$this->Session->setFlash('Erro ao excluir o post.');

		return $this->redirect(array('action' => 'index'));
	}
}
