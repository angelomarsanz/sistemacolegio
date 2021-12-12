<br />
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Agregar nueva calificación descriptiva de la materia'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="observacions index large-9 medium-8 columns content">
    <h5>Estudiante: <?= $estudiante->full_name ?></h5>
    <h5>Lapso: <?= $lapso->numero_lapso ?></h5>
    <h4><?= __('Calificaciones descriptivas de la materia: ' . $materia->full_name) ?></h4>
    <table cellpadding="0" cellspacing="0">
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
                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $observacion->id]) ?>
                    <?= $this->Html->link(__('Modificar'), ['action' => 'edit', $observacion->id]) ?>
                    <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $observacion->id], ['confirm' => __('Está usted seguro de que desea eliminar la calificación: {0}?', $observacion->tipo_observacion)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Siguiente') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
