<h2>Editar usuário</h2>

<?php
	echo '<p>';

	echo $this->Form->create('User');

	echo $this->Form->input(
		'username',
		array(
			'label' => 'Novo nome de usuario',
		)
	);

	echo $this->Form->input(
		'password',
		array(
			'label' => 'Nova senha',
			'value' => '',
			'required' => false,
		)
	);

	echo $this->Form->input(
		'role',
		array(
			'label' => 'Perfil do usuário',
			'options' => array(
				'author' => 'Autor',
				'admin' => 'Administrador',
				'superadmin' => 'Super Administrador'
			)
		)
	);

	echo $this->Form->end('Salvar alterações');
?>
