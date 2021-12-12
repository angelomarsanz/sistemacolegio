<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $literalAno->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $literalAno->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Literal Anos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="literalAnos form large-9 medium-8 columns content">
    <?= $this->Form->create($literalAno) ?>
    <fieldset>
        <legend><?= __('Edit Literal Ano') ?></legend>
        <?php
            echo $this->Form->input('student_id', ['options' => $students]);
            echo $this->Form->input('periodo_escolar');
            echo $this->Form->input('calificacion_descriptiva');
            echo $this->Form->input('literal');
            echo $this->Form->input('registro_eliminado');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
