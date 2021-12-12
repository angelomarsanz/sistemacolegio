<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $observacionesAno->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $observacionesAno->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Observaciones Anos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="observacionesAnos form large-9 medium-8 columns content">
    <?= $this->Form->create($observacionesAno) ?>
    <fieldset>
        <legend><?= __('Edit Observaciones Ano') ?></legend>
        <?php
            echo $this->Form->input('student_id', ['options' => $students]);
            echo $this->Form->input('periodo_escolar');
            echo $this->Form->input('tipo_observacion');
            echo $this->Form->input('parrafo_1');
            echo $this->Form->input('parrafo_2');
            echo $this->Form->input('parrafo_3');
            echo $this->Form->input('parrafo_4');
            echo $this->Form->input('parrafo_5');
            echo $this->Form->input('registro_eliminado');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
