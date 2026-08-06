<?php
$usuarioLogado = $this->Session->read('Auth.User');

$ehDono =
	!empty($usuarioLogado) &&
	$usuarioLogado['id'] == $post['Post']['user_id'];

$ehAdministrador =
	!empty($usuarioLogado) &&
	(
		$usuarioLogado['role'] === 'admin' ||
		$usuarioLogado['role'] === 'superadmin'
	);

$ehRascunho =
	$post['Post']['status'] === 'inativo';

$podeGerenciar =
	$ehDono ||
	($ehAdministrador && !$ehRascunho);
?>

<article
	class="card shadow-sm"
	style="
		background: #ffffff;
		border: 0;
		border-left: 5px solid #e07a5f;
		border-radius: 0.65rem;
	"
>
	<div class="card-body p-4">

		<div class="d-flex justify-content-between align-items-start mb-3">

			<h1 class="h3 card-title mb-0">
				<?php echo h($post['Post']['titulo']); ?>
			</h1>

			<?php if (!empty($usuarioLogado)): ?>

				<span
					class="badge badge-<?php
					echo $post['Post']['status'] === 'ativo'
						? 'success'
						: 'secondary';
					?>"
				>
					<?php
					echo $post['Post']['status'] === 'ativo'
						? 'Postagem'
						: 'Rascunho';
					?>
				</span>

			<?php endif; ?>

		</div>

		<div
			class="post-content"
			style="overflow-wrap: anywhere;"
		>
			<?php
			echo nl2br(
				h($post['Post']['conteudo'])
			);
			?>
		</div>

		<hr
			style="
				border: 0;
				border-top: 1px solid #e6e1d8;
				margin: 1.5rem 0 1rem;
			"
		>

		<div class="post-meta mb-4">

			<?php if (!empty($post['User']['username'])): ?>

				<span>
					<strong>Autor:</strong>

					<?php
					echo h($post['User']['username']);
					?>
				</span>

			<?php endif; ?>

			<?php if (!empty($post['Post']['created'])): ?>

				<span>
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

		<div class="d-flex flex-wrap align-items-center">

			<?php
			echo $this->Html->link(
				'Voltar',
				array(
					'controller' => 'posts',
					'action' => 'index'
				),
				array(
					'class' => 'btn mr-2 mb-2',
					'style' => '
						background-color: #e07a5f;
						border-color: #e07a5f;
						color: #ffffff !important;
					'
				)
			);
			?>

			<?php if ($podeGerenciar): ?>

				<?php
				echo $this->Html->link(
					'Editar',
					array(
						'controller' => 'posts',
						'action' => 'edit',
						$post['Post']['id']
					),
					array(
						'class' => 'btn btn-primary mr-2 mb-2'
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
						'class' => 'btn btn-danger mb-2'
					),
					'Deseja realmente excluir esta postagem?'
				);
				?>

			<?php endif; ?>

		</div>

	</div>
</article>
