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
		),
		'user_id' => array(
			// A qui é obrigatorio preencher o ID de usuário
			'obrigatorio' => array(
				'rule' => 'notBlank',
				'message' => 'Informe o autor da postagem.'

			),
			'numerico' => array(
				'rule' => 'numeric',
	            'message' => 'O autor é inválido.'
			),
		)
	);
}
