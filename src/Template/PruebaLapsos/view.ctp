<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Prueba Lapso'), ['action' => 'edit', $pruebaLapso->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Prueba Lapso'), ['action' => 'delete', $pruebaLapso->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pruebaLapso->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Prueba Lapsos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Prueba Lapso'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Materias'), ['controller' => 'Materias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Materia'), ['controller' => 'Materias', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="pruebaLapsos view large-9 medium-8 columns content">
    <h3><?= h($pruebaLapso->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Lapso') ?></th>
            <td><?= $pruebaLapso->has('lapso') ? $this->Html->link($pruebaLapso->lapso->id, ['controller' => 'Lapsos', 'action' => 'view', $pruebaLapso->lapso->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Materia') ?></th>
            <td><?= $pruebaLapso->has('materia') ? $this->Html->link($pruebaLapso->materia->id, ['controller' => 'Materias', 'action' => 'view', $pruebaLapso->materia->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Student') ?></th>
            <td><?= $pruebaLapso->has('student') ? $this->Html->link($pruebaLapso->student->full_name, ['controller' => 'Students', 'action' => 'view', $pruebaLapso->student->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($pruebaLapso->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Puntaje') ?></th>
            <td><?= $this->Number->format($pruebaLapso->puntaje) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Puntaje 112') ?></th>
            <td><?= $this->Number->format($pruebaLapso->puntaje_112) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($pruebaLapso->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($pruebaLapso->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registro Eliminado') ?></th>
            <td><?= $pruebaLapso->registro_eliminado ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Observacion Prueba') ?></h4>
        <?= $this->Text->autoParagraph(h($pruebaLapso->observacion_prueba)); ?>
    </div>
    <div class="row">
        <h4><?= __('Observacion General Lapso') ?></h4>
        <?= $this->Text->autoParagraph(h($pruebaLapso->observacion_general_lapso)); ?>
    </div>
</div>
