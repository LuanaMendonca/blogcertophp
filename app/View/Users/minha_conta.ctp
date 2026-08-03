<?php
$usuarioLogado = $this->Session->read('Auth.User');
?>

<div class="mb-4">
	<h1 class="page-title mb-1">Minha conta</h1>
	<p class="text-muted mb-0">
		Edite seu nome de usuário ou altere sua senha.
	</p>
</div>

<div class="card shadow-sm">
	<div class="card-body">

		<?php
		echo $this->Form->create('User');
		?>

		<div class="form-group">
			<?php
			echo $this->Form->input(
				'username',
				array(
					'label' => 'Nome de usuário',
					'class' => 'form-control'
				)
			);
			?>
		</div>

		<div class="form-group">
			<?php
			echo $this->Form->input(
				'password',
				array(
					'label' => 'Nova senha',
					'type' => 'password',
					'class' => 'form-control',
					'value' => '',
					'required' => false,
					'placeholder' => 'Deixe vazio para manter a senha atual'
				)
			);
			?>
		</div>

		<div class="form-group">
			<label>Perfil</label>

			<input
				type="text"
				class="form-control"
				value="<?php echo h($usuarioLogado['role']); ?>"
				disabled
			>
		</div>

		<?php
		echo $this->Form->button(
			'Salvar alterações',
			array(
				'type' => 'submit',
				'class' => 'btn btn-primary'
			)
		);

		echo $this->Form->end();
		?>

		<hr>

		<h2 class="h5 text-danger">Excluir conta</h2>

		<p class="text-muted">
			Ao excluir sua conta, todas as suas postagens também serão apagadas.
		</p>

		<?php
		echo $this->Form->postLink(
			'Excluir minha conta',
			array(
				'controller' => 'users',
				'action' => 'delete',
				$usuarioLogado['id']
			),
			array(
				'class' => 'btn btn-outline-danger'
			),
			'Tem certeza? Sua conta e todas as suas postagens serão excluídas.'
		);
		?>

	</div>
</div>
