<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Profesor'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="profesors index large-9 medium-8 columns content">
    <h3><?= __('Profesors') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Nombre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Cédula o pasaporte') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($profesors as $profesor): ?>
            <tr>
                <td><?= h($profesor->full_name) ?></td>
                <td><?= h($profesor->tipo_documento_identificacion . '-' . $profesor->numero_documento_identificacion) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $profesor->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $profesor->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $profesor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $profesor->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>