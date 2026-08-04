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
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'Este nome de usuário já está sendo utilizado.'
			)
		),
		'password' => array(
			'notBlank' => array(
				'rule' => 'notBlank',
				'message' => 'Informe uma senha.'
			)
		),
		'confirmPassword' => array(
			'notBlank' => array(
				'rule' => 'notBlank',
				'message' => 'Confirme sua senha.'
			),
			'same' => array(
				'rule' => 'isConfirmPassword',
				'message' => 'Senhas não coincidem'
			)
		),

		'role' => array(
			'notBlank' => array(
				'rule' => 'notBlank',
				'message' => 'Informe o perfil.'
			),
			'validRole' => array(
				'rule' => array('inList', array('superadmin','admin', 'author')),
				'message' => 'Selecione um perfil, autor ou administrador.'
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
	public function beforeSave($options = array())
	{
		if (empty($this->data[$this->alias]['password'])) {
			return true;
		}

		$senha = $this->data[$this->alias]['password'];

		$geradorDeSenha = new SimplePasswordHasher();

		$this->data[$this->alias]['password'] =
			$geradorDeSenha->hash($senha);

		return true;
	}
}
