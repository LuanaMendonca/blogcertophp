<?php
$cakeDescription = __d('cake_dev', 'Pets: blog sobre cuidados e adoção');

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('cake.generic');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');

	?>
</head>
<body>
	<div id="container">
		<div id="content">

			<?php

			if ($this->Session->check('Auth.User')):

				?>

				<div style="margin-bottom:20px; font-weight:bold;">
					<?php
					echo h($this->Session->read('Auth.User.username'));
					?>
					<?php
					if ($this->Session->read('Auth.User.role') == 'admin') {
						echo 'Administrador';
					} elseif ($this->Session->read('Auth.User.role') == 'superadmin') {
						echo 'Super Administrador';

						echo ' | ';

						echo $this->Html->link(
							'Gereciar usuários',
							array(
							'controller' => 'users',
							'action' => 'index'
							)
						);
					} else {
						echo 'Autor';
					}

					echo ' | ';

					echo $this->Html->link(
						'Sair',
						array(
							'controller' => 'Users',
							'action' => 'logout'
						)
					);
					?>
				</div>

			<?php endif; ?>

			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>

		</div>

	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
