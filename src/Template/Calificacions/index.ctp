<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Calificacion'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Objetivos'), ['controller' => 'Objetivos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Objetivo'), ['controller' => 'Objetivos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="calificacions index large-9 medium-8 columns content">
    <h3><?= __('Calificacions') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('objetivo_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('student_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('puntaje') ?></th>
                <th scope="col"><?= $this->Paginator->sort('puntaje_112') ?></th>
                <th scope="col"><?= $this->Paginator->sort('registro_eliminado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($calificacions as $calificacion): ?>
            <tr>
                <td><?= $this->Number->format($calificacion->id) ?></td>
                <td><?= $calificacion->has('objetivo') ? $this->Html->link($calificacion->objetivo->id, ['controller' => 'Objetivos', 'action' => 'view', $calificacion->objetivo->id]) : '' ?></td>
                <td><?= $calificacion->has('student') ? $this->Html->link($calificacion->student->full_name, ['controller' => 'Students', 'action' => 'view', $calificacion->student->id]) : '' ?></td>
                <td><?= $this->Number->format($calificacion->puntaje) ?></td>
                <td><?= $this->Number->format($calificacion->puntaje_112) ?></td>
                <td><?= h($calificacion->registro_eliminado) ?></td>
                <td><?= h($calificacion->created) ?></td>
                <td><?= h($calificacion->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $calificacion->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $calificacion->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $calificacion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $calificacion->id)]) ?>
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
