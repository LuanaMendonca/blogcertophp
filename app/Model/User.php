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
