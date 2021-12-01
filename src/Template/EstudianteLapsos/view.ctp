<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Estudiante Lapso'), ['action' => 'edit', $estudianteLapso->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Estudiante Lapso'), ['action' => 'delete', $estudianteLapso->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estudianteLapso->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Estudiante Lapsos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Estudiante Lapso'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Materias'), ['controller' => 'Materias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Materia'), ['controller' => 'Materias', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="estudianteLapsos view large-9 medium-8 columns content">
    <h3><?= h($estudianteLapso->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Student') ?></th>
            <td><?= $estudianteLapso->has('student') ? $this->Html->link($estudianteLapso->student->full_name, ['controller' => 'Students', 'action' => 'view', $estudianteLapso->student->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lapso') ?></th>
            <td><?= $estudianteLapso->has('lapso') ? $this->Html->link($estudianteLapso->lapso->id, ['controller' => 'Lapsos', 'action' => 'view', $estudianteLapso->lapso->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Materia') ?></th>
            <td><?= $estudianteLapso->has('materia') ? $this->Html->link($estudianteLapso->materia->id, ['controller' => 'Materias', 'action' => 'view', $estudianteLapso->materia->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($estudianteLapso->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($estudianteLapso->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($estudianteLapso->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registro Eliminado') ?></th>
            <td><?= $estudianteLapso->registro_eliminado ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
