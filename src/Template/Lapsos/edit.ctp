<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $lapso->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $lapso->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Lapsos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Estudiante Lapsos'), ['controller' => 'EstudianteLapsos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Estudiante Lapso'), ['controller' => 'EstudianteLapsos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Literal Lapsos'), ['controller' => 'LiteralLapsos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Literal Lapso'), ['controller' => 'LiteralLapsos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Literal Materias'), ['controller' => 'LiteralMaterias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Literal Materia'), ['controller' => 'LiteralMaterias', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Objetivos'), ['controller' => 'Objetivos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Objetivo'), ['controller' => 'Objetivos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Observacions'), ['controller' => 'Observacions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Observacion'), ['controller' => 'Observacions', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Parametros Carga Calificacions'), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Parametros Carga Calificacion'), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Prueba Lapsos'), ['controller' => 'PruebaLapsos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Prueba Lapso'), ['controller' => 'PruebaLapsos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="lapsos form large-9 medium-8 columns content">
    <?= $this->Form->create($lapso) ?>
    <fieldset>
        <legend><?= __('Edit Lapso') ?></legend>
        <?php
            echo $this->Form->input('periodo_escolar');
            echo $this->Form->input('numero_lapso');
            echo $this->Form->input('registro_eliminado');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
