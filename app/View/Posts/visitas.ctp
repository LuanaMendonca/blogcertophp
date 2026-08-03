<section class="hero-section text-center mb-5">
	<h1 class="display-4 font-weight-bold">Bem-vindo ao PetBlog</h1>

	<p class="lead mb-4">
		Conteúdos sobre cuidados, bem-estar e adoção de animais.
	</p>

	<?php if (!$this->Session->check('Auth.User')): ?>
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

<div class="mb-4">
	<h2 class="page-title">Postagens recentes</h2>

	<p class="text-muted">
		As postagens publicadas ficam disponíveis para todos os visitantes.
	</p>
</div>

<?php if (empty($posts)): ?>

	<div class="alert alert-info">
		Nenhuma postagem disponível.
	</div>

<?php else: ?>

	<div class="row">
		<?php foreach ($posts as $post): ?>

			<div class="col-12 col-md-6 mb-4">

				<a
					href="<?php echo $this->Html->url(array(
						'controller' => 'posts',
						'action' => 'view',
						$post['Post']['id']
					)); ?>"
					class="d-block h-100"
					style="color: inherit; text-decoration: none;"
				>
					<article
						class="card post-card h-100 shadow-sm"
						style="cursor: pointer;"
					>
						<div class="card-body d-flex flex-column">

							<h3 class="h4 card-title">
								<?php echo h($post['Post']['titulo']); ?>
							</h3>

							<p class="card-text post-content flex-grow-1">
								<?php
								echo nl2br(
									h($post['Post']['conteudo'])
								);
								?>
							</p>

							<div class="post-meta mt-3">

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
