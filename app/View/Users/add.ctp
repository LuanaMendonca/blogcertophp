<h2>Cadastrar</h2>

<?php
	echo $this->Form->create('User');

	echo $this->Form->input('username', array(
		'label' => 'Usuário'
		)
	);
	echo $this->Form->input('password', array(
		'label' => 'Senha'
		)
	);

	echo $this->Form->input(
		'role', array(
			'label' => 'Perfil',
			'type' => 'select',
			'options' => array(
				'author' => 'Autor',
				'admin' => 'Administrador'
			),
		'empty' => 'Selecione um perfil'
		)
	);

	echo $this->Form->end('Cadastrar');
?>
