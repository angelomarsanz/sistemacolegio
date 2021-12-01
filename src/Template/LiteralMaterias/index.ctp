<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Literal Materia'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Materias'), ['controller' => 'Materias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Materia'), ['controller' => 'Materias', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="literalMaterias index large-9 medium-8 columns content">
    <h3><?= __('Literal Materias') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lapso_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('materia_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('student_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('literal') ?></th>
                <th scope="col"><?= $this->Paginator->sort('registro_eliminado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($literalMaterias as $literalMateria): ?>
            <tr>
                <td><?= $this->Number->format($literalMateria->id) ?></td>
                <td><?= $literalMateria->has('lapso') ? $this->Html->link($literalMateria->lapso->id, ['controller' => 'Lapsos', 'action' => 'view', $literalMateria->lapso->id]) : '' ?></td>
                <td><?= $literalMateria->has('materia') ? $this->Html->link($literalMateria->materia->id, ['controller' => 'Materias', 'action' => 'view', $literalMateria->materia->id]) : '' ?></td>
                <td><?= $literalMateria->has('student') ? $this->Html->link($literalMateria->student->full_name, ['controller' => 'Students', 'action' => 'view', $literalMateria->student->id]) : '' ?></td>
                <td><?= h($literalMateria->literal) ?></td>
                <td><?= h($literalMateria->registro_eliminado) ?></td>
                <td><?= h($literalMateria->created) ?></td>
                <td><?= h($literalMateria->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $literalMateria->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $literalMateria->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $literalMateria->id], ['confirm' => __('Are you sure you want to delete # {0}?', $literalMateria->id)]) ?>
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
