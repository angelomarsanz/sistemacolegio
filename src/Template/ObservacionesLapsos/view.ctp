<div class="container">
    <div class="page-header">    
        <?= $this->Html->link(__('Lista de calificaciones descriptivas de lapso'), ['action' => 'index'], ['class' => 'btn btn-sm btn-default']) ?>
        <?= $this->Html->link(__('Modificar calificación descriptiva de lapso'), ['action' => 'edit', $observacionesLapso->id], ['class' => 'btn btn-sm btn-default']) ?>
        <?= $this->Form->postLink(__('Eliminar calificación descriptiva de lapso'), ['action' => 'delete', $observacionesLapso->id], ['class' => 'btn btn-sm btn-default', 'confirm' => __('Está usted seguro de que desea eliminar la calificacion descriptiva {0}?', $observacionesLapso->tipo_observacion)]) ?>
        <?= $this->Html->link(__('Agregar nueva calificación descriptiva de lapso'), ['action' => 'add'], ['class' => 'btn btn-sm btn-default']) ?>
        <h2>Calificación descriptiva de lapso</h2>
    </div>
    <div class="row">
        <div class="col col-sm-12">
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
                <h5><b><?= __('Parrafo 1:') ?></b></h5>
                <?= $this->Text->autoParagraph(h($observacionesLapso->parrafo_1)); ?>
            </div>
            <div class="row">
                <h5><b><?= __('Parrafo 2:') ?></b></h5>
                <?= $this->Text->autoParagraph(h($observacionesLapso->parrafo_2)); ?>
            </div>
            <div class="row">
                <h5><b><?= __('Parrafo 3:') ?></b></h5>
                <?= $this->Text->autoParagraph(h($observacionesLapso->parrafo_3)); ?>
            </div>
            <div class="row">
                <h5><b><?= __('Parrafo 4:') ?></b></h5>
                <?= $this->Text->autoParagraph(h($observacionesLapso->parrafo_4)); ?>
            </div>
            <div class="row">
                <h5><b><?= __('Parrafo 5:') ?></b></h5>
                <?= $this->Text->autoParagraph(h($observacionesLapso->parrafo_5)); ?>
            </div>
        </div>
    </div>
</div>
