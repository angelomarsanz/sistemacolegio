<br />
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Lista de calificaciones descriptivas de lapso'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Modificar calificación descriptiva de Lapso'), ['action' => 'edit', $observacionesLapso->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Eliminar calificación descriptiva de lapso'), ['action' => 'delete', $observacionesLapso->id], ['confirm' => __('Está usted seguro de que desea eliminar la calificación {0}?', $observacionesLapso->tipo_observacion)]) ?> </li>
        <li><?= $this->Html->link(__('Agregar nueva calificación descriptiva de Lapso'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="observacionesLapsos view large-9 medium-8 columns content">
    <h3>Calificación descriptiva de lapso</h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Lapso: ') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= $observacionesLapso->has('lapso') ? $this->Html->link($observacionesLapso->lapso->id, ['controller' => 'Lapsos', 'action' => 'view', $observacionesLapso->lapso->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Student') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= $observacionesLapso->has('student') ? $this->Html->link($observacionesLapso->student->full_name, ['controller' => 'Students', 'action' => 'view', $observacionesLapso->student->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipo Observacion') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= h($observacionesLapso->tipo_observacion) ?></td>
        </tr>
    </table>
    <div class="row">
        <h5><?= __('Parrafo 1') ?></h5>
        <?= $this->Text->autoParagraph(h($observacionesLapso->parrafo_1)); ?>
    </div>
    <div class="row">
        <h5><?= __('Parrafo 2') ?></h5>
        <?= $this->Text->autoParagraph(h($observacionesLapso->parrafo_2)); ?>
    </div>
    <div class="row">
        <h5><?= __('Parrafo 3') ?></h5>
        <?= $this->Text->autoParagraph(h($observacionesLapso->parrafo_3)); ?>
    </div>
    <div class="row">
        <h5><?= __('Parrafo 4') ?></h5>
        <?= $this->Text->autoParagraph(h($observacionesLapso->parrafo_4)); ?>
    </div>
    <div class="row">
        <h5><?= __('Parrafo 5') ?></h5>
        <?= $this->Text->autoParagraph(h($observacionesLapso->parrafo_5)); ?>
    </div>
</div>
