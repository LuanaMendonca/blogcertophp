<h1>Lista de postagens:</h1>

<?php

$usuarioLogado = $this->Session->read('Auth.User');

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

			$dataPost = strtotime($post['Post']['created']);

			echo '<p>';
			echo 'Publicado em: ';
			echo date('d/m/Y', $dataPost);
			echo ' às ';
			echo date('H:i', $dataPost);
			echo '</p>';

		} else {

			echo '<p>Data da publicação não informada.</p>';
		}

		echo '<p>';
		echo 'Status: ';
		echo h($post['Post']['status']);
		echo '</p>';

		$podeEditar =
			!empty($usuarioLogado) &&
			(
				$usuarioLogado['role'] == 'superadmin' ||
				$usuarioLogado['role'] == 'admin' ||
				$usuarioLogado['id'] == $post['Post']['user_id']
			);

		if ($podeEditar) {

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
