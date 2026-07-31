<?php
$cakeDescription = 'PetBlog';
$usuarioLogado = $this->Session->read('Auth.User');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<?php echo $this->Html->charset(); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?php echo h($cakeDescription); ?></title>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
	<?php echo $this->Html->css('blog'); ?>

	<?php
		echo $this->Html->meta('icon');
		echo $this->fetch('meta');
		echo $this->fetch('css');
	?>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
		<div class="container">
			<?php
				echo $this->Html->link(
					'PetBlog',
					array('controller' => 'posts', 'action' => 'visitas'),
					array('class' => 'navbar-brand font-weight-bold')
				);
			?>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Abrir menu">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="menuPrincipal">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<?php
							echo $this->Html->link(
								'Início',
								array('controller' => 'posts', 'action' => 'visitas'),
								array('class' => 'nav-link')
							);
						?>
					</li>

					<?php if (!empty($usuarioLogado)): ?>
						<li class="nav-item">
							<?php
								echo $this->Html->link(
									'Postagens',
									array('controller' => 'posts', 'action' => 'index'),
									array('class' => 'nav-link')
								);
							?>
						</li>
						<li class="nav-item">
							<?php
								echo $this->Html->link(
									'Nova postagem',
									array('controller' => 'posts', 'action' => 'add'),
									array('class' => 'nav-link')
								);
							?>
						</li>

						<?php if ($usuarioLogado['role'] === 'superadmin'): ?>
							<li class="nav-item">
								<?php
									echo $this->Html->link(
										'Usuários',
										array('controller' => 'users', 'action' => 'index'),
										array('class' => 'nav-link')
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
									$perfil = isset($perfis[$usuarioLogado['role']]) ? $perfis[$usuarioLogado['role']] : $usuarioLogado['role'];
									echo h($usuarioLogado['username']) . ' — ' . h($perfil);
								?>
							</span>
						</li>
						<li class="nav-item">
							<?php
								echo $this->Html->link(
									'Sair',
									array('controller' => 'users', 'action' => 'logout'),
									array('class' => 'btn btn-outline-light btn-sm')
								);
							?>
						</li>
					<?php else: ?>
						<li class="nav-item mr-lg-2">
							<?php
								echo $this->Html->link(
									'Entrar',
									array('controller' => 'users', 'action' => 'login'),
									array('class' => 'nav-link')
								);
							?>
						</li>
						<li class="nav-item">
							<?php
								echo $this->Html->link(
									'Criar conta',
									array('controller' => 'users', 'action' => 'add'),
									array('class' => 'btn btn-light btn-sm')
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
			<small>PetBlog — cuidados e adoção de animais</small>
		</div>
	</footer>

	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
	<?php echo $this->Html->script('blog'); ?>
	<?php echo $this->fetch('script'); ?>
</body>
</html>
