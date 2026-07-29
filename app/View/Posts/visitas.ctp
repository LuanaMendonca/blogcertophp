<h2>Postagens do blog</h2>

<p>Querido Visitante faça cadastro ou login para poder interagir com as postagem ou criar as suas.</p>

<?php

	echo $this->Html->link(
		'Fazer login',
		array(
			'controller' => 'users',
			'action' => 'login'
		),
		array(
			'class' => 'btn btn-primary',
		)
	);
	echo '<br><br>';
	echo $this->Html->link(
		'Cadastrar Usuário',
		array(
			'controller' => 'users',
			'action' => 'add'
		),
		array(
			'class' => 'btn btn-primary',
		)
	);

	if (empty($posts)) {
		echo '<p>Nenhum posts disponivel</p>';
	} else {
		foreach ($posts as $post) {
			echo '<br><br>';
			echo '<hr>';
			echo '<h3>' . h($post['Post']['titulo']) . '</h3>';
			echo '<h1>' . h($post['Post']['conteudo']) . '</h1>';

		}
	}

	?>
