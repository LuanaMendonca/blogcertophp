<div class="form-page">
	<div class="card form-card shadow-sm">
		<div class="card-body p-4">
			<h1 class="h3 mb-4">Cadastrar postagem</h1>

			<?php
				echo $this->Form->create('Post');

				echo $this->Form->input('titulo', array(
					'label' => 'Título',
					'div' => 'form-group',
					'class' => 'form-control'
				));

				echo $this->Form->input('conteudo', array(
					'label' => 'Conteúdo',
					'type' => 'textarea',
					'rows' => 7,
					'div' => 'form-group',
					'class' => 'form-control'
				));

				echo $this->Form->input('status', array(
					'label' => 'Status',
					'type' => 'select',
					'options' => array(
						'ativo' => 'Postagem',
						'inativo' => 'Rascunho'
					),
					'div' => 'form-group',
					'class' => 'form-control'
				));
			?>

			<div class="d-flex flex-column flex-sm-row">
				<?php
					echo $this->Form->end(array(
						'label' => 'Cadastrar',
						'class' => 'btn btn-primary mr-sm-2 mb-2 mb-sm-0'
					));

					echo $this->Html->link(
						'Cancelar',
						array('controller' => 'posts', 'action' => 'index'),
						array('class' => 'btn btn-outline-secondary')
					);
				?>
			</div>
		</div>
	</div>
</div>
