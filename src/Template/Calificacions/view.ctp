<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Calificacion'), ['action' => 'edit', $calificacion->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Calificacion'), ['action' => 'delete', $calificacion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $calificacion->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Calificacions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Calificacion'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Objetivos'), ['controller' => 'Objetivos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Objetivo'), ['controller' => 'Objetivos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="calificacions view large-9 medium-8 columns content">
    <h3><?= h($calificacion->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Objetivo') ?></th>
            <td><?= $calificacion->has('objetivo') ? $this->Html->link($calificacion->objetivo->id, ['controller' => 'Objetivos', 'action' => 'view', $calificacion->objetivo->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Student') ?></th>
            <td><?= $calificacion->has('student') ? $this->Html->link($calificacion->student->full_name, ['controller' => 'Students', 'action' => 'view', $calificacion->student->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($calificacion->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Puntaje') ?></th>
            <td><?= $this->Number->format($calificacion->puntaje) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Puntaje 112') ?></th>
            <td><?= $this->Number->format($calificacion->puntaje_112) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($calificacion->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($calificacion->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registro Eliminado') ?></th>
            <td><?= $calificacion->registro_eliminado ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
