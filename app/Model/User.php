<?php

App::uses('AppModel', 'Model');
App::uses(
	'SimplePasswordHasher',
	'Controller/Component/Auth'
);

class User extends AppModel
{
	public $validate = array(
		'username' => array(
			'notBlank' => array(
				'rule' => 'notBlank',
				'message' => 'Informe o nome de usuário.'
			),
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'message' =>
					'Use apenas letras e números, sem espaços ou caracteres especiais.'
			),
			'unique' => array(
				'rule' => 'isUnique',
				'message' =>
					'Este nome de usuário já está sendo utilizado.'
			)
		),

		'password' => array(
			'notBlank' => array(
				'rule' => 'notBlank',
				'message' => 'Informe uma senha.',
				'on' => 'create'
			),
			'minLength' => array(
				'rule' => array(
					'minLength',
					3
				),
				'message' =>
					'A senha deve ter no mínimo 3 caracteres.',
				'allowEmpty' => true
			),
			'maxLength' => array(
				'rule' => array(
					'maxLength',
					5
				),
				'message' =>
					'A senha deve ter no máximo 5 caracteres.',
				'allowEmpty' => true
			)
		),

		'confirmPassword' => array(
			'notBlank' => array(
				'rule' => 'notBlank',
				'message' => 'Confirme sua senha.',
				'on' => 'create'
			),
			'same' => array(
				'rule' => 'isConfirmPassword',
				'message' => 'As senhas não coincidem.'
			)
		),

		'role' => array(
			'notBlank' => array(
				'rule' => 'notBlank',
				'message' => 'Informe o perfil.'
			),
			'validRole' => array(
				'rule' => array(
					'inList',
					array(
						'superadmin',
						'admin',
						'author'
					)
				),
				'message' => 'Selecione um perfil válido.'
			)
		)
	);

	public $hasMany = array(
		'Post' => array(
			'className' => 'Post',
			'foreignKey' => 'user_id',
			'dependent' => true
		)
	);

	public function isConfirmPassword($check)
	{
		if (
			empty(
			$this->data[$this->alias]['password']
			)
		) {
			return true;
		}

		if (
			!isset(
				$this->data[
				$this->alias
				]['confirmPassword']
			)
		) {
			return false;
		}

		return
			$check['confirmPassword'] ===
			$this->data[$this->alias]['password'];
	}

	public function beforeSave($options = array())
	{
		if (
			empty(
			$this->data[$this->alias]['password']
			)
		) {
			return true;
		}

		$senha =
			$this->data[$this->alias]['password'];

		$geradorDeSenha =
			new SimplePasswordHasher();

		$this->data[$this->alias]['password'] =
			$geradorDeSenha->hash($senha);

		return true;
	}
}
