<?php $usuarioLogado = $this->Session->read('Auth.User'); ?>

	<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
		<div>
			<h1 class="page-title mb-1">Lista de postagens</h1>
			<p class="text-muted mb-0">Gerencie as postagens do blog.</p>
		</div>

		<?php
		echo $this->Html->link(
			'Adicionar postagem',
			array(
				'controller' => 'posts',
				'action' => 'add'
			),
			array(
				'class' => 'btn btn-primary mt-3 mt-md-0'
			)
		);
		?>
	</div>

	<form
		method="get"
		action="<?php echo $this->Html->url(array(
			'controller' => 'posts',
			'action' => 'index'
		)); ?>"
		class="mb-4"
	>
		<div class="form-row align-items-end">

			<div class="col-md-7 mb-2">
				<label for="busca">Buscar postagem</label>

				<input
					type="text"
					name="busca"
					id="busca"
					class="form-control"
					placeholder="Buscar por título ou conteúdo"
					value="<?php echo h($this->request->query('busca')); ?>"
				>
			</div>

			<div class="col-md-3 mb-2">
				<label for="status">Status</label>

				<select name="status" id="status" class="form-control">
					<option value="">Todos</option>

					<option
						value="ativo"
						<?php echo $this->request->query('status') === 'ativo'
							? 'selected'
							: ''; ?>
					>
						Ativo
					</option>

					<option
						value="inativo"
						<?php echo $this->request->query('status') === 'inativo'
							? 'selected'
							: ''; ?>
					>
						Inativo
					</option>
				</select>
			</div>

			<div class="col-md-2 mb-2">
				<button type="submit" class="btn btn-primary btn-block">
					Buscar
				</button>
			</div>

		</div>
	</form>

<?php if (empty($posts)): ?>

	<div class="alert alert-info">
		Nenhuma postagem encontrada.
	</div>

<?php else: ?>

	<div class="row">
		<?php foreach ($posts as $post): ?>

			<?php
			$podeEditar = !empty($usuarioLogado) && (
					$usuarioLogado['role'] === 'superadmin' ||
					$usuarioLogado['role'] === 'admin' ||
					$usuarioLogado['id'] == $post['Post']['user_id']
				);
			?>

			<div class="col-12 mb-4">
				<article class="card post-card shadow-sm">
					<div class="card-body">

						<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-start">
							<h2 class="h4 card-title mb-2">
								<?php echo h($post['Post']['titulo']); ?>
							</h2>

							<span class="badge badge-<?php
							echo $post['Post']['status'] === 'ativo'
								? 'success'
								: 'secondary';
							?> mb-3 mb-md-0">
								<?php echo h(ucfirst($post['Post']['status'])); ?>
							</span>
						</div>

						<p class="card-text post-content">
							<?php echo nl2br(h($post['Post']['conteudo'])); ?>
						</p>

						<div class="post-meta mb-3">
							<span>
								<strong>Autor:</strong>
								<?php echo h($post['User']['username']); ?>
							</span>

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

						<?php if ($podeEditar): ?>
							<div class="post-actions">
								<?php
								echo $this->Html->link(
									'Editar',
									array(
										'controller' => 'posts',
										'action' => 'edit',
										$post['Post']['id']
									),
									array(
										'class' => 'btn btn-outline-primary btn-sm'
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
										'class' => 'btn btn-outline-danger btn-sm ml-2'
									),
									'Tem certeza que deseja excluir esta postagem?'
								);
								?>
							</div>
						<?php endif; ?>

					</div>
				</article>
			</div>

		<?php endforeach; ?>
	</div>

<?php endif; ?>
