<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Agregar Nuevo Lapso'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="lapsos index large-9 medium-8 columns content">
    <h3><?= __('Lapsos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Período Escolar') ?>&nbsp;&nbsp;&nbsp;</th>
                <th scope="col"><?= $this->Paginator->sort(' Número de lapso') ?>&nbsp;&nbsp;&nbsp;</th>
                <th scope="col" class="actions"><?= __('Acciones') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lapsos as $lapso): ?>
            <tr>
                <td><?= h($lapso->periodo_escolar) ?>&nbsp;&nbsp;&nbsp;</td>
                <td><?= $this->Number->format($lapso->numero_lapso) ?>&nbsp;&nbsp;&nbsp;</td>
                <td class="actions">
                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $lapso->id]) ?>
                    <?= $this->Html->link(__('Modificar'), ['action' => 'edit', $lapso->id]) ?>
                    <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $lapso->id], ['confirm' => __('Está usted seguro de que desea eliminar el lapso # {0}?', $lapso->numero_lapso)]) ?>
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