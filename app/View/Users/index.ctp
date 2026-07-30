<h2>Usuários cadastrados</h2>

<h2> Editar Usuários </h2>



<?php

foreach ($usuarios as $usuario) {

	echo '<p>';

	echo '<strong>Usuário:</strong> ';
	echo h($usuario['User']['username']);

	echo '<br><br>';

	echo '<strong>Tipo de Perfil:</strong> ';
	echo h($usuario['User']['role']);

	echo '<br><br>';

	echo $this->Html->link(
		'Editar Perfil',
		array(
			'controller' => 'users',
			'action' => 'edit',
			$usuario['User']['id']
		)
	);

	echo ' | ';

	echo $this->Html->link(
		'Excluir',
		array(
			'controller' => 'users',
			'action' => 'delete',
			$usuario['User']['id']
		)
	);



	echo '</p>';

	echo '<hr>';
}
?>
