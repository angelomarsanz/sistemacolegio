<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Observaciones Lapso'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="observacionesLapsos index large-9 medium-8 columns content">
    <h3><?= __('Observaciones Lapsos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lapso_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('student_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tipo_observacion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('registro_eliminado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($observacionesLapsos as $observacionesLapso): ?>
            <tr>
                <td><?= $this->Number->format($observacionesLapso->id) ?></td>
                <td><?= $observacionesLapso->has('lapso') ? $this->Html->link($observacionesLapso->lapso->id, ['controller' => 'Lapsos', 'action' => 'view', $observacionesLapso->lapso->id]) : '' ?></td>
                <td><?= $observacionesLapso->has('student') ? $this->Html->link($observacionesLapso->student->full_name, ['controller' => 'Students', 'action' => 'view', $observacionesLapso->student->id]) : '' ?></td>
                <td><?= h($observacionesLapso->tipo_observacion) ?></td>
                <td><?= h($observacionesLapso->registro_eliminado) ?></td>
                <td><?= h($observacionesLapso->created) ?></td>
                <td><?= h($observacionesLapso->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $observacionesLapso->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $observacionesLapso->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $observacionesLapso->id], ['confirm' => __('Are you sure you want to delete # {0}?', $observacionesLapso->id)]) ?>
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
