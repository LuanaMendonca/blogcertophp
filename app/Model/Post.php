<?php

App::uses('AppModel', 'Model');

class Post extends AppModel
{
	public $useTable = 'posts';

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		)
	);

	public $validate = array(
		'titulo' => array(
			'obrigatorio' => array(
				'rule' => 'notBlank',
				'message' => 'Informe o título da postagem.'
			)
		),

		'conteudo' => array(
			'obrigatorio' => array(
				'rule' => 'notBlank',
				'message' => 'Informe o conteúdo da postagem.'
			)
		),

		'status' => array(
			'valido' => array(
				'rule' => array(
					'inList',
					array('ativo', 'inativo')
				),
				'message' => 'Selecione um status válido.'
			)
		)
	);
}
