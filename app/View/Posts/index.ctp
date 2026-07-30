<h1>Lista de postagens:</h1>

<?php

if (empty($posts)) {

	echo '<p>Nenhuma postagem cadastrada.</p>';

} else {

	foreach ($posts as $post) {

		echo '<h2>';
		echo h($post['Post']['titulo']);
		echo '</h2>';

		echo '<p>';
		echo h($post['Post']['conteudo']);
		echo '</p>';

		echo '<p>';
		echo 'Autor: ';
		echo h($post['User']['username']);
		echo '</p>';

		if (!empty($post['Post']['created'])) {

			$data = $this->Time->format(
				'd/m/Y',
				$post['Post']['created']
			);

			$hora = $this->Time->format(
				'H:i',
				$post['Post']['created']
			);

			echo '<p>';
			echo 'Publicado em: ' . $data . ' às ' . $hora;
			echo '</p>';
		}

		echo '<p>';
		echo 'Status: ';
		echo h($post['Post']['status']);
		echo '</p>';

		$usuarioLogado = $this->Session->read('Auth.User');

		$pode_editar =
			!empty($usuarioLogado) &&
			(
				$usuarioLogado['role'] == 'superadmin' ||
				$usuarioLogado['role'] == 'admin' ||
				$usuarioLogado['id'] == $post['Post']['user_id']
			);

		if ($pode_editar) {

			echo '<div>';

			echo $this->Html->link(
				'Editar',
				array(
					'controller' => 'posts',
					'action' => 'edit',
					$post['Post']['id']
				)
			);

			echo ' | ';

			echo $this->Form->postLink(
				'Excluir',
				array(
					'controller' => 'posts',
					'action' => 'delete',
					$post['Post']['id']
				),
				array(),
				'Tem certeza que deseja excluir esta postagem?'
			);

			echo '</div>';
		}

		echo '<hr>';
	}
}

?>
