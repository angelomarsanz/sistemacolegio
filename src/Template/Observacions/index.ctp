<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Observacion'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="observacions index large-9 medium-8 columns content">
    <h3><?= __('Observacions') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lapso_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('student_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('registro_elimindo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($observacions as $observacion): ?>
            <tr>
                <td><?= $this->Number->format($observacion->id) ?></td>
                <td><?= $observacion->has('lapso') ? $this->Html->link($observacion->lapso->id, ['controller' => 'Lapsos', 'action' => 'view', $observacion->lapso->id]) : '' ?></td>
                <td><?= $observacion->has('student') ? $this->Html->link($observacion->student->full_name, ['controller' => 'Students', 'action' => 'view', $observacion->student->id]) : '' ?></td>
                <td><?= h($observacion->registro_elimindo) ?></td>
                <td><?= h($observacion->created) ?></td>
                <td><?= h($observacion->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $observacion->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $observacion->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $observacion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $observacion->id)]) ?>
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
