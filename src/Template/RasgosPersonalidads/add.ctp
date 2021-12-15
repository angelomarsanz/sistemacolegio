<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Rasgos Personalidads'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Materias'), ['controller' => 'Materias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Materia'), ['controller' => 'Materias', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Opciones Usuarios'), ['controller' => 'OpcionesUsuarios', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Opciones Usuario'), ['controller' => 'OpcionesUsuarios', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="rasgosPersonalidads form large-9 medium-8 columns content">
    <?= $this->Form->create($rasgosPersonalidad) ?>
    <fieldset>
        <legend><?= __('Add Rasgos Personalidad') ?></legend>
        <?php
            echo $this->Form->input('lapso_id', ['options' => $lapsos]);
            echo $this->Form->input('materia_id', ['options' => $materias]);
            echo $this->Form->input('student_id', ['options' => $students]);
            echo $this->Form->input('opciones_usuario_id', ['options' => $opcionesUsuarios]);
            echo $this->Form->input('calificacion');
            echo $this->Form->input('registro_eliminado');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
