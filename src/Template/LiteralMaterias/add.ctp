<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Literal Materias'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Materias'), ['controller' => 'Materias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Materia'), ['controller' => 'Materias', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="literalMaterias form large-9 medium-8 columns content">
    <?= $this->Form->create($literalMateria) ?>
    <fieldset>
        <legend><?= __('Add Literal Materia') ?></legend>
        <?php
            echo $this->Form->input('lapso_id', ['options' => $lapsos]);
            echo $this->Form->input('materia_id', ['options' => $materias]);
            echo $this->Form->input('student_id', ['options' => $students]);
            echo $this->Form->input('calificacion_descriptiva');
            echo $this->Form->input('literal');
            echo $this->Form->input('registro_eliminado');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
