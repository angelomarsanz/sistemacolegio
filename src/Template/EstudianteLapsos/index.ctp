<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Estudiante Lapso'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Materias'), ['controller' => 'Materias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Materia'), ['controller' => 'Materias', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="estudianteLapsos index large-9 medium-8 columns content">
    <h3><?= __('Estudiante Lapsos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('student_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lapso_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('materia_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('registro_eliminado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estudianteLapsos as $estudianteLapso): ?>
            <tr>
                <td><?= $this->Number->format($estudianteLapso->id) ?></td>
                <td><?= $estudianteLapso->has('student') ? $this->Html->link($estudianteLapso->student->full_name, ['controller' => 'Students', 'action' => 'view', $estudianteLapso->student->id]) : '' ?></td>
                <td><?= $estudianteLapso->has('lapso') ? $this->Html->link($estudianteLapso->lapso->id, ['controller' => 'Lapsos', 'action' => 'view', $estudianteLapso->lapso->id]) : '' ?></td>
                <td><?= $estudianteLapso->has('materia') ? $this->Html->link($estudianteLapso->materia->id, ['controller' => 'Materias', 'action' => 'view', $estudianteLapso->materia->id]) : '' ?></td>
                <td><?= h($estudianteLapso->registro_eliminado) ?></td>
                <td><?= h($estudianteLapso->created) ?></td>
                <td><?= h($estudianteLapso->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $estudianteLapso->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $estudianteLapso->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $estudianteLapso->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estudianteLapso->id)]) ?>
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
