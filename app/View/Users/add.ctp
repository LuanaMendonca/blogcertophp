<div class="form-page form-page-small">
	<div class="card form-card shadow-sm">
		<div class="card-body p-4">

			<h1 class="h3 mb-2">
				Criar conta
			</h1>

			<p class="text-muted mb-4">
				Cadastre-se para criar e administrar suas postagens.
			</p>

			<?php
			echo $this->Form->create('User');

			echo $this->Form->input(
				'username',
				array(
					'label' => 'Usuário',
					'div' => 'form-group',
					'class' => 'form-control',
					'pattern' => '[A-Za-z0-9]+',
					'title' =>
						'Use apenas letras e números.'
				)
			);

			echo $this->Form->input(
				'password',
				array(
					'label' => 'Senha',
					'type' => 'password',
					'div' => 'form-group',
					'class' => 'form-control',
					'minlength' => 3,
					'maxlength' => 5
				)
			);

			echo $this->Form->input(
				'confirmPassword',
				array(
					'label' => 'Confirmar senha',
					'type' => 'password',
					'div' => 'form-group',
					'class' => 'form-control',
					'minlength' => 3,
					'maxlength' => 5
				)
			);

			echo $this->Form->end(
				array(
					'label' => 'Cadastrar',
					'class' => 'btn btn-primary btn-block'
				)
			);
			?>

			<p class="text-center mt-4 mb-0">
				Já possui uma conta?

				<?php
				echo $this->Html->link(
					'Fazer login',
					array(
						'controller' => 'users',
						'action' => 'login'
					)
				);
				?>
			</p>

		</div>
	</div>
</div>
