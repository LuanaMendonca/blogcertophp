<div class="mb-4">
	<h1 class="page-title mb-1">Usuários cadastrados</h1>
	<p class="text-muted mb-0">Edite o nome, a senha ou o perfil dos usuários.</p>
</div>

<?php if (empty($usuarios)): ?>
	<div class="alert alert-info">Nenhum usuário cadastrado.</div>
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
						<tr>
							<td><?php echo h($usuario['User']['username']); ?></td>
							<td><?php echo h($usuario['User']['role']); ?></td>
							<td class="text-right">
								<?php
									echo $this->Html->link(
										'Editar perfil',
										array('controller' => 'users', 'action' => 'edit', $usuario['User']['id']),
										array('class' => 'btn btn-outline-primary btn-sm')
									);
								?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
<?php endif; ?>
