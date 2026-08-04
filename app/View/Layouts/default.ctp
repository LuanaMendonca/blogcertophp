<?php
$cakeDescription = 'PetBlog';
$usuarioLogado = $this->Session->read('Auth.User');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<?php echo $this->Html->charset(); ?>

	<meta
		name="viewport"
		content="width=device-width, initial-scale=1, shrink-to-fit=no"
	>

	<title><?php echo h($cakeDescription); ?></title>

	<link
		rel="icon"
		type="image/x-icon"
		href="<?php echo $this->Html->url('/petblog-favicon.ico'); ?>?v=1"
	>

	<link
		rel="shortcut icon"
		type="image/x-icon"
		href="<?php echo $this->Html->url('/petblog-favicon.ico'); ?>?v=1"
	>

	<link
		rel="stylesheet"
		href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
	>

	<link
		rel="stylesheet"
		href="<?php echo $this->Html->url('/css/blog.css'); ?>?v=2"
	>

	<?php
	echo $this->fetch('meta');
	echo $this->fetch('css');
	?>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm py-2">
	<div class="container">

		<?php
		$marcaPetBlog =
			$this->Html->image(
				'cachorro-petblog.png',
				array(
					'alt' => 'PetBlog',
					'style' => '
						height: 44px;
						width: 44px;
						object-fit: contain;
						filter: drop-shadow(0 2px 2px rgba(0, 0, 0, 0.15));
					'
				)
			)
			.
			'<span style="
				font-size: 1.35rem;
				font-weight: 800;
				letter-spacing: 0.3px;
				line-height: 1;
				margin-left: 9px;
				white-space: nowrap;
			">
				<span style="color: #fff8ed;">Pet</span><span style="color: #f4b183;">Blog</span>
			</span>';

		echo $this->Html->link(
			$marcaPetBlog,
			array(
				'controller' => 'posts',
				'action' => 'visitas'
			),
			array(
				'class' => 'navbar-brand d-flex align-items-center py-0 mr-lg-4',
				'style' => 'text-decoration: none;',
				'escape' => false
			)
		);
		?>

		<button
			class="navbar-toggler"
			type="button"
			data-toggle="collapse"
			data-target="#menuPrincipal"
			aria-controls="menuPrincipal"
			aria-expanded="false"
			aria-label="Abrir menu"
		>
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="menuPrincipal">

			<ul class="navbar-nav mr-auto">

				<li class="nav-item">
					<?php
					echo $this->Html->link(
						'Início',
						array(
							'controller' => 'posts',
							'action' => 'visitas'
						),
						array(
							'class' => 'nav-link'
						)
					);
					?>
				</li>

				<?php if (!empty($usuarioLogado)): ?>

					<li class="nav-item">
						<?php
						echo $this->Html->link(
							'Postagens',
							array(
								'controller' => 'posts',
								'action' => 'index'
							),
							array(
								'class' => 'nav-link'
							)
						);
						?>
					</li>

					<li class="nav-item">
						<?php
						echo $this->Html->link(
							'Nova postagem',
							array(
								'controller' => 'posts',
								'action' => 'add'
							),
							array(
								'class' => 'nav-link'
							)
						);
						?>
					</li>

					<li class="nav-item">
						<?php
						echo $this->Html->link(
							'Minha conta',
							array(
								'controller' => 'users',
								'action' => 'minhaConta'
							),
							array(
								'class' => 'nav-link'
							)
						);
						?>
					</li>

					<?php if (
						$usuarioLogado['role'] === 'admin' ||
						$usuarioLogado['role'] === 'superadmin'
					): ?>

						<li class="nav-item">
							<?php
							echo $this->Html->link(
								'Gerenciar usuários',
								array(
									'controller' => 'users',
									'action' => 'index'
								),
								array(
									'class' => 'nav-link'
								)
							);
							?>
						</li>

					<?php endif; ?>

				<?php endif; ?>

			</ul>

			<ul class="navbar-nav align-items-lg-center">

				<?php if (!empty($usuarioLogado)): ?>

					<li class="nav-item mr-lg-3">
						<span class="navbar-text user-info">

							<?php
							$perfis = array(
								'author' => 'Autor',
								'admin' => 'Administrador',
								'superadmin' => 'Super Administrador'
							);

							$perfil = isset($perfis[$usuarioLogado['role']])
								? $perfis[$usuarioLogado['role']]
								: $usuarioLogado['role'];

							echo h($usuarioLogado['username'])
								. ' — '
								. h($perfil);
							?>

						</span>
					</li>

					<li class="nav-item">
						<?php
						echo $this->Html->link(
							'Sair',
							array(
								'controller' => 'users',
								'action' => 'logout'
							),
							array(
								'class' => 'btn btn-outline-light btn-sm'
							)
						);
						?>
					</li>

				<?php else: ?>

					<li class="nav-item mr-lg-2">
						<?php
						echo $this->Html->link(
							'Entrar',
							array(
								'controller' => 'users',
								'action' => 'login'
							),
							array(
								'class' => 'nav-link'
							)
						);
						?>
					</li>

					<li class="nav-item">
						<?php
						echo $this->Html->link(
							'Criar conta',
							array(
								'controller' => 'users',
								'action' => 'add'
							),
							array(
								'class' => 'btn btn-light btn-sm'
							)
						);
						?>
					</li>

				<?php endif; ?>

			</ul>

		</div>
	</div>
</nav>

<main class="container py-4">

	<?php echo $this->Session->flash(); ?>

	<?php echo $this->fetch('content'); ?>

</main>

<footer class="footer py-4 mt-5">
	<div class="container text-center">

		<div class="mb-2">
			<?php
			echo $this->Html->image(
				'cachorro-petblog.png',
				array(
					'alt' => 'Mascote do PetBlog',
					'style' => '
						height: 48px;
						width: 48px;
						object-fit: contain;
					'
				)
			);
			?>
		</div>

		<small>
			PetBlog — cuidados e adoção de animais
		</small>

	</div>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="<?php echo $this->Html->url('/js/blog.js'); ?>?v=2"></script>

<?php echo $this->fetch('script'); ?>

</body>
</html>
