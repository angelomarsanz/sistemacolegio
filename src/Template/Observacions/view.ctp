<div class="container">
    <div class="page-header">    
        <?= $this->Html->link(__('Lista de calificaciones descriptivas de materia'), ['action' => 'index'], ['class' => 'btn btn-sm btn-default']) ?>
        <?= $this->Html->link(__('Modificar calificación descriptiva de materia'), ['action' => 'edit', $observacion->id], ['class' => 'btn btn-sm btn-default']) ?>
        <?= $this->Form->postLink(__('Eliminar calificación descriptiva de materia'), ['action' => 'delete', $observacion->id], ['class' => 'btn btn-sm btn-default', 'confirm' => __('Está usted seguro de que desea eliminar la calificacion descriptiva {0}?', $observacion->tipo_observacion)]) ?>
        <?= $this->Html->link(__('Agregar nueva calificación descriptiva de la materia'), ['action' => 'add'], ['class' => 'btn btn-sm btn-default']) ?>
        <h2>Calificación descriptiva de materia</h2>
    </div>
    <div class="row">
        <div class="col col-sm-12">
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
                <h5><b><?= __('Parrafo 1:') ?></b></h5>
                <?= $this->Text->autoParagraph(h($observacion->parrafo_1)); ?>
            </div>
            <div class="row">
                <h5><b><?= __('Parrafo 2:') ?></b></h5>
                <?= $this->Text->autoParagraph(h($observacion->parrafo_2)); ?>
            </div>
            <div class="row">
                <h5><b><?= __('Parrafo 3:') ?></b></h5>
                <?= $this->Text->autoParagraph(h($observacion->parrafo_3)); ?>
            </div>
            <div class="row">
                <h5><b><?= __('Parrafo 4:') ?></b></h5>
                <?= $this->Text->autoParagraph(h($observacion->parrafo_4)); ?>
            </div>
            <div class="row">
                <h5><b><?= __('Parrafo 5:') ?></b></h5>
                <?= $this->Text->autoParagraph(h($observacion->parrafo_5)); ?>
            </div>
        </div>
    </div>
</div>