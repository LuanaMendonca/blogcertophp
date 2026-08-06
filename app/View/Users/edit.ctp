<div class="form-page">
	<div class="card form-card shadow-sm">
		<div class="card-body p-4">

			<h1 class="h3 mb-4">
				Editar usuário
			</h1>

			<?php
			echo $this->Form->create('User');

			echo $this->Form->input(
				'username',
				array(
					'label' => 'Nome de usuário',
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
					'label' => 'Nova senha',
					'type' => 'password',
					'value' => '',
					'required' => false,
					'div' => 'form-group',
					'class' => 'form-control',
					'minlength' => 3,
					'maxlength' => 5,
					'placeholder' =>
						'Deixe vazio para manter a senha atual'
				)
			);

			echo $this->Form->input(
				'confirmPassword',
				array(
					'label' => 'Confirmar nova senha',
					'type' => 'password',
					'value' => '',
					'required' => false,
					'div' => 'form-group',
					'class' => 'form-control',
					'minlength' => 3,
					'maxlength' => 5
				)
			);

			echo $this->Form->input(
				'role',
				array(
					'label' => 'Perfil do usuário',
					'type' => 'select',
					'options' => array(
						'author' => 'Autor',
						'admin' => 'Administrador',
						'superadmin' =>
							'Super Administrador'
					),
					'div' => 'form-group',
					'class' => 'form-control'
				)
			);
			?>

			<div class="d-flex flex-column flex-sm-row">

				<?php
				echo $this->Form->end(
					array(
						'label' => 'Salvar alterações',
						'class' =>
							'btn btn-primary mr-sm-2 mb-2 mb-sm-0'
					)
				);

				echo $this->Html->link(
					'Cancelar',
					array(
						'controller' => 'users',
						'action' => 'index'
					),
					array(
						'class' => 'btn btn-outline-secondary'
					)
				);
				?>

			</div>

		</div>
	</div>
</div>
