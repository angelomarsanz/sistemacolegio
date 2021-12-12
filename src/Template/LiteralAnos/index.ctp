<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Literal Ano'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="literalAnos index large-9 medium-8 columns content">
    <h3><?= __('Literal Anos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('student_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('periodo_escolar') ?></th>
                <th scope="col"><?= $this->Paginator->sort('literal') ?></th>
                <th scope="col"><?= $this->Paginator->sort('registro_eliminado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($literalAnos as $literalAno): ?>
            <tr>
                <td><?= $this->Number->format($literalAno->id) ?></td>
                <td><?= $literalAno->has('student') ? $this->Html->link($literalAno->student->full_name, ['controller' => 'Students', 'action' => 'view', $literalAno->student->id]) : '' ?></td>
                <td><?= h($literalAno->periodo_escolar) ?></td>
                <td><?= h($literalAno->literal) ?></td>
                <td><?= h($literalAno->registro_eliminado) ?></td>
                <td><?= h($literalAno->created) ?></td>
                <td><?= h($literalAno->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $literalAno->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $literalAno->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $literalAno->id], ['confirm' => __('Are you sure you want to delete # {0}?', $literalAno->id)]) ?>
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
