<h1>Editando postagem</h1>

<p>
	<strong>Post de:</strong>

	<?php
		echo h($post['User']['username']);
	?>
</p>

<?php

echo $this->Form->create('Post');

echo $this->Form->input(
	'titulo',
	array(
		'label' => 'Título'
	)
);

echo $this->Form->input(
	'conteudo',
	array(
		'label' => 'Conteúdo',
		'type' => 'textarea'
	)
);

echo $this->Form->input(
	'status',
	array(
		'label' => 'Status',
		'type' => 'select',
		'options' => array(
			'ativo' => 'Ativo',
			'inativo' => 'Inativo'
		)
	)
);

echo $this->Form->end('Salvar alterações');
