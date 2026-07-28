<h1>Cadastrar Postagem</h1>

<?php

	echo $this->Form->create('Post');

	echo $this->Form->input('titulo', array(
		'label' => 'Titúlo',)
	);
	echo $this->Form->input('conteudo', array(
		'label' => 'Conteúdo',)
	);

	echo $this->Form->input('status', array(
		'type' => 'select',
		'options' => array(
			'ativo' => 'Ativo',
			'inativo' => 'Inativo')
		)
	);

	echo $this->Form->end('Enviar');

?>
