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
		$busca = $this->request->query('busca');
		$status = $this->request->query('status');

		if (!empty($status)) {
			$conditions['Post.status'] = $status;
		}

		if(!empty($busca)){
			$conditions['OR'] = array(
				'Post.titulo LIKE' =>'%'.$busca.'%',
				'Post.conteudo LIKE' =>'%'.$busca.'%'
			);
		}

		$posts = $this->Post->find(
			'all',
			array(
				'conditions' => $conditions

			)
		);

		$this->set('posts', $posts);
	}
	public function add()
	{
		if ($this->request->is('post')) {

			$this->Post->create();

			$this->request->data['Post']['user_id'] = $this->Auth->user('id');

			if ($this->Post->save($this->request->data)) {

				$this->Session->setFlash('Post cadastrado com sucesso.');

				return $this->redirect(array('action' => 'index'));

			} else {

				$this->Session->setFlash('Erro ao cadastrar o post.');
			}
		}
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
