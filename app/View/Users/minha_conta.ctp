<?php
$usuarioLogado =
	$this->Session->read('Auth.User');

$perfis = array(
	'author' => 'Autor',
	'admin' => 'Administrador',
	'superadmin' => 'Super Administrador'
);

$perfil =
	isset($perfis[$usuarioLogado['role']])
		? $perfis[$usuarioLogado['role']]
		: $usuarioLogado['role'];
?>

<div class="mb-4">
	<h1 class="page-title mb-1">
		Minha conta
	</h1>

	<p class="text-muted mb-0">
		Edite seu nome de usuário ou altere sua senha.
	</p>
</div>

<div class="card form-card shadow-sm">
	<div class="card-body p-4">

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
		?>

		<div class="form-group">
			<label for="perfil">
				Perfil
			</label>

			<input
				type="text"
				id="perfil"
				class="form-control"
				value="<?php echo h($perfil); ?>"
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

		<h2 class="h5 text-danger">
			Excluir conta
		</h2>

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
