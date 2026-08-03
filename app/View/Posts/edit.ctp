<div class="form-page">
	<div class="card form-card shadow-sm">
		<div class="card-body p-4">
			<h1 class="h3 mb-2">Editar postagem</h1>
			<p class="text-muted mb-4">
				Post de: <strong><?php echo h($post['User']['username']); ?></strong>
			</p>

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
						'ativo' => 'Postado',
						'inativo' => 'Pascunho'
					),
					'div' => 'form-group',
					'class' => 'form-control'
				));
			?>

			<div class="d-flex flex-column flex-sm-row">
				<?php
					echo $this->Form->end(array(
						'label' => 'Salvar alterações',
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
