<br />
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Agregar nuevo objetivo'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="objetivos index large-9 medium-8 columns content">
    <h3><?= __('Objetivos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col">Materia&nbsp;&nbsp;&nbsp;</th>
                <th scope="col">Profesor&nbsp;&nbsp;&nbsp;</th>
                <th scope="col">Lapso&nbsp;&nbsp;&nbsp;</th>
                <th scope="col">Objetivo&nbsp;&nbsp;&nbsp;</th>
                <th scope="col">Descripción&nbsp;&nbsp;&nbsp;</th>
                <th scope="col" class="actions"><?= __('Acciones') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($objetivos as $objetivo): ?>
            <tr>
                <td><?= $objetivo->has('materia') ? $this->Html->link($objetivo->materia->full_name, ['controller' => 'Materias', 'action' => 'view', $objetivo->materia->id]) : '' ?>&nbsp;&nbsp;&nbsp;</td>
                <td><?= $objetivo->has('profesor') ? $this->Html->link($objetivo->profesor->primer_apellido . ' ' . $objetivo->profesor->primer_nombre, ['controller' => 'Profesors', 'action' => 'view', $objetivo->profesor->id]) : '' ?>&nbsp;&nbsp;&nbsp;</td>
                <td><?= $objetivo->has('lapso') ? $this->Html->link($objetivo->lapso->numero_lapso, ['controller' => 'Lapsos', 'action' => 'view', $objetivo->lapso->id]) : '' ?>&nbsp;&nbsp;&nbsp;</td>
                <td><?= $objetivo->objetivo ?>&nbsp;&nbsp;&nbsp;</td>
                <td><?= substr($objetivo->descripcion, 0, 15) ?>&nbsp;&nbsp;&nbsp;</td>
                <td class="actions">
                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $objetivo->id]) ?>
                    <?= $this->Html->link(__('Modificar'), ['action' => 'edit', $objetivo->id]) ?>
                    <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $objetivo->id], ['confirm' => __('Está usted seguro que desea eliminar el objetivo {0}?', $objetivo->objetivo)]) ?>
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