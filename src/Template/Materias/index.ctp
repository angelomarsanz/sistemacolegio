<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Agregar una nueva materia'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="materias index large-9 medium-8 columns content">
    <h3><?= __('Materias') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Materia') ?>&nbsp;&nbsp;&nbsp;</th>
                <th scope="col"><?= $this->Paginator->sort('Grado') ?>&nbsp;&nbsp;&nbsp;</th>
                <th scope="col"><?= $this->Paginator->sort('Horas') ?>&nbsp;&nbsp;&nbsp;</th>
                <th scope="col" class="actions"><?= __('Acciones') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($materias as $materia): ?>
            <tr>
                <td><?= h($materia->nombre_materia) ?>&nbsp;&nbsp;&nbsp;</td>
                <td><?= h($materia->grado_materia) ?>&nbsp;&nbsp;&nbsp;</td>
                <td><?= h($materia->cantidad_horas_semanales) ?>&nbsp;&nbsp;&nbsp;</td>
                <td class="actions">
                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $materia->id]) ?>
                    <?= $this->Html->link(__('Modificar'), ['action' => 'edit', $materia->id]) ?>
                    <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $materia->id], ['confirm' => __('Está seguro de que desea eliminar la materia {0} ?', $materia->nombre_materia)]) ?>
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