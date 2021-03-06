<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Consecutiveinvoice'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="consecutiveinvoices index large-9 medium-8 columns content">
    <h3><?= __('Consecutiveinvoices') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('requesting_user') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($consecutiveinvoices as $consecutiveinvoice): ?>
            <tr>
                <td><?= $this->Number->format($consecutiveinvoice->id) ?></td>
                <td><?= h($consecutiveinvoice->requesting_user) ?></td>
                <td><?= h($consecutiveinvoice->created) ?></td>
                <td><?= h($consecutiveinvoice->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $consecutiveinvoice->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $consecutiveinvoice->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $consecutiveinvoice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $consecutiveinvoice->id)]) ?>
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
