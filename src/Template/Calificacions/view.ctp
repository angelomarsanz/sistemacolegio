<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Acciones') ?></li>
        <li><?= $this->Html->link(__('Listado de calificaciones'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Agregar nueva calificacion'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Modificar calificacion'), ['action' => 'edit', $calificacion->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Eliminar calificacion'), ['action' => 'delete', $calificacion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $calificacion->id)]) ?> </li>
    </ul>
</nav>
<div class="calificacions view large-9 medium-8 columns content">
    <h5>Identificador: <?= h($calificacion->id) ?></h5>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Estudiante') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= $calificacion->has('student') ? $this->Html->link($calificacion->student->full_name, ['controller' => 'Students', 'action' => 'view', $calificacion->student->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Objetivo') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= $calificacion->has('objetivo') ? $this->Html->link($calificacion->objetivo->objetivo, ['controller' => 'Objetivos', 'action' => 'view', $calificacion->objetivo->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Puntaje') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= $this->Number->format($calificacion->puntaje) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Puntaje 112') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= $this->Number->format($calificacion->puntaje_112) ?></td>
        </tr>
    </table>
</div>
