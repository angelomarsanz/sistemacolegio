<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Literal Lapso'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="literalLapsos index large-9 medium-8 columns content">
    <h3><?= __('Literal Lapsos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lapso_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('student_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('literal') ?></th>
                <th scope="col"><?= $this->Paginator->sort('registro_eliminado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($literalLapsos as $literalLapso): ?>
            <tr>
                <td><?= $this->Number->format($literalLapso->id) ?></td>
                <td><?= $literalLapso->has('lapso') ? $this->Html->link($literalLapso->lapso->id, ['controller' => 'Lapsos', 'action' => 'view', $literalLapso->lapso->id]) : '' ?></td>
                <td><?= $literalLapso->has('student') ? $this->Html->link($literalLapso->student->full_name, ['controller' => 'Students', 'action' => 'view', $literalLapso->student->id]) : '' ?></td>
                <td><?= h($literalLapso->literal) ?></td>
                <td><?= h($literalLapso->registro_eliminado) ?></td>
                <td><?= h($literalLapso->created) ?></td>
                <td><?= h($literalLapso->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $literalLapso->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $literalLapso->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $literalLapso->id], ['confirm' => __('Are you sure you want to delete # {0}?', $literalLapso->id)]) ?>
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
