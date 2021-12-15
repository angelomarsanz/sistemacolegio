<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Opciones Usuarios'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Materias'), ['controller' => 'Materias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Materia'), ['controller' => 'Materias', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Rasgos Personalidads'), ['controller' => 'RasgosPersonalidads', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Rasgos Personalidad'), ['controller' => 'RasgosPersonalidads', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="opcionesUsuarios form large-9 medium-8 columns content">
    <?= $this->Form->create($opcionesUsuario) ?>
    <fieldset>
        <legend><?= __('Add Opciones Usuario') ?></legend>
        <?php
            echo $this->Form->input('user_id', ['options' => $users]);
            echo $this->Form->input('lapso_id', ['options' => $lapsos]);
            echo $this->Form->input('materia_id', ['options' => $materias]);
            echo $this->Form->input('tipo_opcion');
            echo $this->Form->input('descripcion_opcion');
            echo $this->Form->input('registro_eliminado');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
