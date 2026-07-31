<div class="form-page form-page-small">
	<div class="card form-card shadow-sm">
		<div class="card-body p-4">
			<h1 class="h3 mb-2">Entrar</h1>
			<p class="text-muted mb-4">Acesse sua conta para administrar as postagens.</p>

			<?php
				echo $this->Form->create('User');

				echo $this->Form->input('username', array(
					'label' => 'Usuário',
					'div' => 'form-group',
					'class' => 'form-control'
				));

				echo $this->Form->input('password', array(
					'label' => 'Senha',
					'div' => 'form-group',
					'class' => 'form-control'
				));

				echo $this->Form->end(array(
					'label' => 'Entrar',
					'class' => 'btn btn-primary btn-block'
				));
			?>

			<p class="text-center mt-4 mb-0">
				Ainda não possui conta?
				<?php
					echo $this->Html->link(
						'Cadastre-se',
						array('controller' => 'users', 'action' => 'add')
					);
				?>
			</p>
		</div>
	</div>
</div>
