<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Agregar nueva calificación'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="calificacions index large-9 medium-8 columns content">
    <h3><?= __('Calificaciones') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Estudiante') ?>&nbsp;&nbsp;&nbsp;</th>
                <th scope="col"><?= $this->Paginator->sort('Objetivo') ?>&nbsp;&nbsp;&nbsp;</th>
                <th scope="col"><?= $this->Paginator->sort('puntaje') ?>&nbsp;&nbsp;&nbsp;</th>
                <th scope="col"><?= $this->Paginator->sort('puntaje_112') ?>&nbsp;&nbsp;&nbsp;</th>
                <th scope="col" class="actions"><?= __('Acciones') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($calificacions as $calificacion): ?>
            <tr>
                <td><?= $calificacion->has('student') ? $this->Html->link($calificacion->student->full_name, ['controller' => 'Students', 'action' => 'view', $calificacion->student->id]) : '' ?>&nbsp;&nbsp;&nbsp;</td>
                <td><?= $calificacion->has('objetivo') ? $this->Html->link($calificacion->objetivo->objetivo, ['controller' => 'Objetivos', 'action' => 'view', $calificacion->objetivo->id]) : '' ?>&nbsp;&nbsp;&nbsp;</td>
                <td><?= $this->Number->format($calificacion->puntaje) ?>&nbsp;&nbsp;&nbsp;</td>
                <td><?= $this->Number->format($calificacion->puntaje_112) ?>&nbsp;&nbsp;&nbsp;</td>
                <td class="actions">
                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $calificacion->id]) ?>
                    <?= $this->Html->link(__('Modificar'), ['action' => 'edit', $calificacion->id]) ?>
                    <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $calificacion->id], ['confirm' => __('Está usted seguro que desea eliminar la calificación del estudiante {0}?', $calificacion->student->full_name)]) ?>
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
