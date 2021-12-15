<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <?= $this->Html->link('Agregar nueva calificación descriptiva de materia', ['action' => 'add'], ['class' => 'btn btn-sm btn-default']); ?>
            <h5>Estudiante: <?= $estudiante->full_name ?></h5>
            <h5>Lapso: <?= $lapso->numero_lapso ?></h5>
            <h4><?= __('Calificaciones descriptivas de la materia: ' . $materia->full_name) ?></h4>
        </div>
        <div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Tipo&nbsp;&nbsp;&nbsp;</th>
                        <th scope="col">Calificacion descriptiva&nbsp;&nbsp;&nbsp;</th>
                        <th scope="col" class="actions"><?= __('Acciones') ?>&nbsp;&nbsp;&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($observacionesMateria as $observacion): ?>
                    <tr>
                        <td><?= $observacion->tipo_observacion ?>&nbsp;&nbsp;&nbsp;</td>
                        <td><?= substr($observacion->parrafo_1, 0, 60) . '...' ?>&nbsp;&nbsp;&nbsp;</td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $observacion->id], ['class' => 'btn btn-sm btn-default']) ?>
                            <?= $this->Html->link(__('Modificar'), ['action' => 'edit', $observacion->id], ['class' => 'btn btn-sm btn-default']) ?>
                            <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $observacion->id], ['confirm' => __('Está usted seguro de que desea eliminar la calificación: {0}?', $observacion->tipo_observacion), 'class' => 'btn btn-sm btn-default']) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('Siguiente') . ' >') ?>
            </ul>
            <p><?= $this->Paginator->counter() ?></p>
        </div>
    </div>
</div>