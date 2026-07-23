<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');

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
				'rule' => array('inList', array('admin', 'author')),
				'message' => 'Selecione um perfil, autor ou administrador.'
			)
		)
	);
	public function beforeSave($options = array())
	{
		if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password(
				$this->data[$this->alias]['password']
			);
		}
		return true;
	}
}
