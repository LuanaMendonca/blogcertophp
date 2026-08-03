<?php
$usuarioLogado = $this->Session->read('Auth.User');
?>

	<div class="mb-4">
		<h1 class="page-title mb-1">Usuários cadastrados</h1>
		<p class="text-muted mb-0">Edite o nome, a senha ou o perfil dos usuários.</p>
	</div>

<?php if (empty($usuarios)): ?>

	<div class="alert alert-info">
		Nenhum usuário cadastrado.
	</div>

<?php else: ?>

	<div class="card shadow-sm">
		<div class="table-responsive">
			<table class="table table-hover mb-0">

				<thead class="thead-light">
				<tr>
					<th>Usuário</th>
					<th>Perfil</th>
					<th class="text-right">Ações</th>
				</tr>
				</thead>

				<tbody>
				<?php foreach ($usuarios as $usuario): ?>

					<?php
					$perfilLogado = $usuarioLogado['role'];
					$perfilUsuario = $usuario['User']['role'];

					$ehPropriaConta =
						(int)$usuarioLogado['id'] ===
						(int)$usuario['User']['id'];

					$podeExcluir = false;

					if ($ehPropriaConta) {
						$podeExcluir = true;
					}

					if (
						$perfilLogado === 'admin' &&
						$perfilUsuario === 'author'
					) {
						$podeExcluir = true;
					}

					if ($perfilLogado === 'superadmin') {
						$podeExcluir = true;
					}
					?>

					<tr>
						<td>
							<?php echo h($usuario['User']['username']); ?>

							<?php if ($ehPropriaConta): ?>
								<small class="text-muted">(você)</small>
							<?php endif; ?>
						</td>

						<td>
							<?php echo h($usuario['User']['role']); ?>
						</td>

						<td class="text-right">

							<?php
							echo $this->Html->link(
								'Editar perfil',
								array(
									'controller' => 'users',
									'action' => 'edit',
									$usuario['User']['id']
								),
								array(
									'class' => 'btn btn-outline-primary btn-sm'
								)
							);
							?>

							<?php if ($podeExcluir): ?>

								<?php
								echo $this->Form->postLink(
									'Excluir',
									array(
										'controller' => 'users',
										'action' => 'delete',
										$usuario['User']['id']
									),
									array(
										'class' => 'btn btn-outline-danger btn-sm ml-1'
									),
									'Tem certeza? A conta e todas as postagens desse usuário serão excluídas.'
								);
								?>

							<?php endif; ?>

						</td>
					</tr>

				<?php endforeach; ?>
				</tbody>

			</table>
		</div>
	</div>

<?php endif; ?>
