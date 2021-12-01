<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Calificacions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Objetivos'), ['controller' => 'Objetivos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Objetivo'), ['controller' => 'Objetivos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="calificacions form large-9 medium-8 columns content">
    <?= $this->Form->create($calificacion) ?>
    <fieldset>
        <legend><?= __('Add Calificacion') ?></legend>
        <?php
            echo $this->Form->input('objetivo_id', ['options' => $objetivos]);
            echo $this->Form->input('student_id', ['options' => $students]);
            echo $this->Form->input('puntaje');
            echo $this->Form->input('puntaje_112');
            echo $this->Form->input('registro_eliminado');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
