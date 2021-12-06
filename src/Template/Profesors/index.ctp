<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Agregar un nuevo profesor'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="profesors index large-9 medium-8 columns content">
    <h3><?= __('Profesores') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Cédula/pasaporte') ?>&nbsp;&nbsp;&nbsp;</th>
                <th scope="col"><?= $this->Paginator->sort('Nombre') ?>&nbsp;&nbsp;&nbsp;</th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($profesors as $profesor): ?>
            <tr>
                <td><?= h($profesor->tipo_documento_identificacion . '-' . $profesor->numero_documento_identificacion) ?>&nbsp;&nbsp;&nbsp;</td>
                <td><?= h($profesor->full_name) ?>&nbsp;&nbsp;&nbsp;</td>
                <td class="actions">
                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $profesor->id]) ?>
                    <?= $this->Html->link(__('Modificar'), ['action' => 'edit', $profesor->id]) ?>
                    <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $profesor->id], ['confirm' => __('Está usted seguro de que desea eliminar el profesor {0}?', $profesor->full_name)]) ?>
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