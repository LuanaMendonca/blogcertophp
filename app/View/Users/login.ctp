<h2>Login</h2>

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

	echo $this->Form->end('Entrar');
?>
