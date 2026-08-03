<?php
$usuarioLogado = $this->Session->read('Auth.User');

$ehDono = !empty($usuarioLogado) &&
	$usuarioLogado['id'] == $post['Post']['user_id'];

$ehAdministrador = !empty($usuarioLogado) && (
		$usuarioLogado['role'] === 'admin' ||
		$usuarioLogado['role'] === 'superadmin'
	);

$ehRascunho = $post['Post']['status'] === 'inativo';

$podeAlterar = $ehDono || (!$ehRascunho && $ehAdministrador);

$acaoVoltar = $this->Session->check('Auth.User')
	? 'index'
	: 'visitas';
?>

<div class="card post-card shadow-sm">
	<div class="card-body p-4">

		<div class="d-flex flex-column flex-md-row justify-content-between">
			<h1 class="h2 mb-3">
				<?php echo h($post['Post']['titulo']); ?>
			</h1>

			<span class="badge badge-<?php
			echo $ehRascunho ? 'secondary' : 'success';
			?> align-self-start mb-3">

				<?php
				echo $ehRascunho
					? 'Rascunho'
					: 'Postagem';
				?>

			</span>
		</div>

		<div class="post-meta mb-4">
			<span>
				<strong>Autor:</strong>
				<?php echo h($post['User']['username']); ?>
			</span>

			<?php if (!empty($post['Post']['created'])): ?>
				<span class="ml-md-3">
					<strong>Publicado em:</strong>

					<?php
					echo date(
						'd/m/Y \à\s H:i',
						strtotime($post['Post']['created'])
					);
					?>
				</span>
			<?php endif; ?>
		</div>

		<div class="post-content mb-4">
			<?php echo nl2br(h($post['Post']['conteudo'])); ?>
		</div>

		<div class="d-flex flex-wrap">

			<?php
			echo $this->Html->link(
				'Voltar',
				array(
					'controller' => 'posts',
					'action' => $acaoVoltar
				),
				array(
					'class' => 'btn btn-outline-secondary mr-2 mb-2'
				)
			);
			?>

			<?php if ($podeAlterar): ?>

				<?php
				echo $this->Html->link(
					'Editar',
					array(
						'controller' => 'posts',
						'action' => 'edit',
						$post['Post']['id']
					),
					array(
						'class' => 'btn btn-outline-primary mr-2 mb-2'
					)
				);

				echo $this->Form->postLink(
					'Excluir',
					array(
						'controller' => 'posts',
						'action' => 'delete',
						$post['Post']['id']
					),
					array(
						'class' => 'btn btn-outline-danger mb-2'
					),
					'Tem certeza que deseja excluir esta postagem?'
				);
				?>

			<?php endif; ?>

		</div>

	</div>
</div>
