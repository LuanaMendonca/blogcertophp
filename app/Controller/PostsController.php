<?php

App::uses('AppController', 'Controller');

	class PostsController extends AppController{

		public function index(){
			$posts = $this->Post->find('all');

			$this->set('posts', $posts);

		}

	}
