<?php
$usuarioLogado = $this->Session->read('Auth.User');
?>

	<section class="hero-section text-center mb-5">
		<h1 class="display-4 font-weight-bold">
			Bem-vindos ao PetBlog!
		</h1>

		<p class="lead mb-4">
			Conteúdos sobre cuidados, bem-estar e adoção de animais.
		</p>

		<?php if (empty($usuarioLogado)): ?>

			<div>
				<?php
				echo $this->Html->link(
					'Fazer login',
					array(
						'controller' => 'users',
						'action' => 'login'
					),
					array(
						'class' => 'btn btn-light mr-2'
					)
				);

				echo $this->Html->link(
					'Criar conta',
					array(
						'controller' => 'users',
						'action' => 'add'
					),
					array(
						'class' => 'btn btn-outline-light'
					)
				);
				?>
			</div>

		<?php endif; ?>
	</section>

	<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

		<div>
			<h2 class="page-title mb-1">
				Postagens recentes
			</h2>

			<p class="text-muted mb-0">
				Confira as postagens publicadas no PetBlog.
			</p>
		</div>

		<?php if (!empty($usuarioLogado)): ?>

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

		<?php endif; ?>

	</div>

<?php if (!empty($usuarioLogado)): ?>

	<form
		id="filtro-postagens"
		method="get"
		action="<?php echo $this->Html->url('/'); ?>"
		class="mb-4"
	>
		<div class="form-row align-items-end">

			<div class="col-md-4 mb-2">
				<label for="busca">
					Buscar postagem
				</label>

				<input
					type="text"
					name="busca"
					id="busca"
					class="form-control"
					placeholder="Buscar por título ou conteúdo"
					value="<?php echo h(
						$this->request->query('busca')
					); ?>"
				>
			</div>

			<div class="col-md-2 mb-2">
				<label for="status">
					Tipo
				</label>

				<select
					name="status"
					id="status"
					class="form-control"
				>
					<option value="">
						Todos
					</option>

					<option
						value="ativo"
						<?php
						echo $this->request->query('status') === 'ativo'
							? 'selected'
							: '';
						?>
					>
						Postagem
					</option>

					<option
						value="inativo"
						<?php
						echo $this->request->query('status') === 'inativo'
							? 'selected'
							: '';
						?>
					>
						Rascunho
					</option>
				</select>
			</div>
			<div class="col-md-2 mb-2">
				<label for="data_inicial">
					Data inicial
				</label>

				<input
					type="text"
					name="data_inicial"
					id="data_inicial"
					class="form-control campo-data"
					placeholder="aaaa-mm-dd"
					autocomplete="off"
					readonly
					value="<?php echo h(
						$this->request->query('data_inicial')
					); ?>"
				>
			</div>

			<div class="col-md-2 mb-2">
				<label for="data_final">
					Data final
				</label>

				<input
					type="text"
					name="data_final"
					id="data_final"
					class="form-control campo-data"
					placeholder="aaaa-mm-dd"
					autocomplete="off"
					readonly
					value="<?php echo h(
						$this->request->query('data_final')
					); ?>"
				>
			</div>

			<script>
				$(function () {
					$('.campo-data').datepicker({
						format: 'yyyy-mm-dd',
						autoclose: true,
						todayHighlight: true,
						enableOnReadonly: true
					});
				});
			</script>

			<div class="col-md-2 mb-2">
				<button
					type="submit"
					class="btn btn-primary btn-block"
				>
					Buscar
				</button>
			</div>

		</div>

		<div class="mt-2">
			<?php
			echo $this->Html->link(
				'Limpar filtros',
				array(
					'controller' => 'posts',
					'action' => 'index'
				),
				array(
					'class' => 'btn btn-outline-secondary btn-sm'
				)
			);
			?>
		</div>
	</form>

<?php endif; ?>

<?php if (empty($posts)): ?>

	<div class="alert alert-info">
		Nenhuma postagem encontrada.
	</div>

<?php else: ?>

	<div class="row">

		<?php foreach ($posts as $post): ?>

			<div class="col-12 mb-4">

				<a
					href="<?php echo $this->Html->url(array(
						'controller' => 'posts',
						'action' => 'view',
						$post['Post']['id']
					)); ?>"
					class="d-block"
					style="color: inherit; text-decoration: none;"
				>

					<article
						class="card post-card shadow-sm"
						style="cursor: pointer;"
					>
						<div class="card-body">

							<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-start">

								<h3 class="h4 card-title mb-2">
									<?php
									echo h(
										$post['Post']['titulo']
									);
									?>
								</h3>

								<?php if (!empty($usuarioLogado)): ?>

									<span
										class="badge badge-<?php
										echo $post['Post']['status'] === 'ativo'
											? 'success'
											: 'secondary';
										?> mb-3 mb-md-0"
									>
										<?php
										echo $post['Post']['status'] === 'ativo'
											? 'Postagem'
											: 'Rascunho';
										?>
									</span>

								<?php endif; ?>

							</div>

							<p class="card-text post-content">
								<?php
								echo nl2br(
									h($post['Post']['conteudo'])
								);
								?>
							</p>

							<div class="post-meta">

								<?php if (!empty($post['User']['username'])): ?>

									<span>
										<strong>Autor:</strong>

										<?php
										echo h(
											$post['User']['username']
										);
										?>
									</span>

								<?php endif; ?>

								<?php if (!empty($post['Post']['created'])): ?>

									<span>
										<strong>Publicado em:</strong>

										<?php
										echo date(
											'd/m/Y \à\s H:i',
											strtotime(
												$post['Post']['created']
											)
										);
										?>
									</span>

								<?php endif; ?>

							</div>

						</div>
					</article>

				</a>

			</div>

		<?php endforeach; ?>

	</div>

<?php endif; ?>
