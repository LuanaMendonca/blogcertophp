<h1>Lista de postagens: </h1>

<?php if (empty($posts)): ?>

    <p> Nenhuma postagem cadastrada.</p>

<?php else: ?>

    <?php foreach ($posts as $post): ?>

        <h2>
            <?php
				echo h($post['Post']['titulo']);
			?>
        </h2>

        <p>
            <?php
				echo h($post['Post']['conteudo']); ?>
        </p>

		<p>
			Autor:<?php echo h($post['User']['username']); ?>
		</p>

        <p>
            Status: <?php echo h($post['Post']['status']); ?>
        </p>

		<p>
			<?php
			$usuarioLogado = $this->Session->read('Auth.User');

			$pode_editar =
				$usuarioLogado['role'] == 'superadmin' ||
				$usuarioLogado['role'] == 'admin' ||
				$usuarioLogado['id'] == $post['Post']['user_id'];

			if ($pode_editar) {
				echo $this->Html->link(
					'Editar',
					'/posts/edit/' . $post['Post']['id']
				);

				echo ' | ';

				echo $this->Html->link(
					'Excluir',
					'/posts/delete/' . $post['Post']['id'],
					array(),
					'Tem certeza que deseja excluir esta postagem?'
				);
			}
			?>
		</p>

        <hr>

    <?php endforeach; ?>

<?php endif; ?>
