<br />
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Lista de calificaciones descriptivas de la materia'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Modificar calificación descriptiva de la materia'), ['action' => 'edit', $observacion->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Eliminar calificación descriptiva de la materia'), ['action' => 'delete', $observacion->id], ['confirm' => __('Está seguro de que desea eliminar la calificación {0}?', $observacion->tipo_observacion)]) ?> </li>
        <li><?= $this->Html->link(__('Agregar nueva calificación descriptiva de la materia'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="observacions view large-9 medium-8 columns content">
    <h3>Calificación descriptiva de la materia</h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Lapso:') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= $observacion->has('lapso') ? $this->Html->link($observacion->lapso->numero_lapso, ['controller' => 'Lapsos', 'action' => 'view', $observacion->lapso->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Materia:') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= $this->Html->link($observacion->materia->full_name, ['controller' => 'Materias', 'action' => 'view', $observacion->materia->id]) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Estudiante:') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= $observacion->has('student') ? $this->Html->link($observacion->student->full_name, ['controller' => 'Students', 'action' => 'view', $observacion->student->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipo:') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= h($observacion->tipo_observacion) ?></td>
        </tr>
    </table>
    <div class="row">
        <h5><?= __('Parrafo 1') ?></h5>
        <?= $this->Text->autoParagraph(h($observacion->parrafo_1)); ?>
    </div>
    <div class="row">
        <h5><?= __('Parrafo 2') ?></h5>
        <?= $this->Text->autoParagraph(h($observacion->parrafo_2)); ?>
    </div>
    <div class="row">
        <h5><?= __('Parrafo 3') ?></h5>
        <?= $this->Text->autoParagraph(h($observacion->parrafo_3)); ?>
    </div>
    <div class="row">
        <h5><?= __('Parrafo 4') ?></h5>
        <?= $this->Text->autoParagraph(h($observacion->parrafo_4)); ?>
    </div>
    <div class="row">
        <h5><?= __('Parrafo 5') ?></h5>
        <?= $this->Text->autoParagraph(h($observacion->parrafo_5)); ?>
    </div>
</div>