<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Parametros Carga Calificacion'), ['action' => 'edit', $parametrosCargaCalificacion->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Parametros Carga Calificacion'), ['action' => 'delete', $parametrosCargaCalificacion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $parametrosCargaCalificacion->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Parametros Carga Calificacions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Parametros Carga Calificacion'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Profesors'), ['controller' => 'Profesors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Profesor'), ['controller' => 'Profesors', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Materias'), ['controller' => 'Materias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Materia'), ['controller' => 'Materias', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sections'), ['controller' => 'Sections', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Section'), ['controller' => 'Sections', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="parametrosCargaCalificacions view large-9 medium-8 columns content">
    <h3><?= h($parametrosCargaCalificacion->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Profesor') ?></th>
            <td><?= $parametrosCargaCalificacion->has('profesor') ? $this->Html->link($parametrosCargaCalificacion->profesor->id, ['controller' => 'Profesors', 'action' => 'view', $parametrosCargaCalificacion->profesor->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lapso') ?></th>
            <td><?= $parametrosCargaCalificacion->has('lapso') ? $this->Html->link($parametrosCargaCalificacion->lapso->id, ['controller' => 'Lapsos', 'action' => 'view', $parametrosCargaCalificacion->lapso->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Materia') ?></th>
            <td><?= $parametrosCargaCalificacion->has('materia') ? $this->Html->link($parametrosCargaCalificacion->materia->id, ['controller' => 'Materias', 'action' => 'view', $parametrosCargaCalificacion->materia->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Section') ?></th>
            <td><?= $parametrosCargaCalificacion->has('section') ? $this->Html->link($parametrosCargaCalificacion->section->full_name, ['controller' => 'Sections', 'action' => 'view', $parametrosCargaCalificacion->section->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($parametrosCargaCalificacion->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($parametrosCargaCalificacion->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($parametrosCargaCalificacion->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registro Eliminado') ?></th>
            <td><?= $parametrosCargaCalificacion->registro_eliminado ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
