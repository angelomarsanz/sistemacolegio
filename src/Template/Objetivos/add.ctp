<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Objetivos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Materias'), ['controller' => 'Materias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Materia'), ['controller' => 'Materias', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Profesors'), ['controller' => 'Profesors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Profesor'), ['controller' => 'Profesors', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Calificacions'), ['controller' => 'Calificacions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Calificacion'), ['controller' => 'Calificacions', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="objetivos form large-9 medium-8 columns content">
    <?= $this->Form->create($objetivo) ?>
    <fieldset>
        <legend><?= __('Add Objetivo') ?></legend>
        <?php
            echo $this->Form->input('lapso_id', ['options' => $lapsos]);
            echo $this->Form->input('materia_id', ['options' => $materias]);
            echo $this->Form->input('profesor_id', ['options' => $profesors]);
            echo $this->Form->input('numero_objetivo');
            echo $this->Form->input('fecha_objetivo', ['empty' => true]);
            echo $this->Form->input('descripcion_objetivo');
            echo $this->Form->input('instrumento_objetivo');
            echo $this->Form->input('ponderacion_objetivo');
            echo $this->Form->input('comentario_objetivo');
            echo $this->Form->input('registro_eliminado');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
