<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Observaciones Ano'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="observacionesAnos index large-9 medium-8 columns content">
    <h3><?= __('Observaciones Anos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('student_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('periodo_escolar') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tipo_observacion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('registro_eliminado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($observacionesAnos as $observacionesAno): ?>
            <tr>
                <td><?= $this->Number->format($observacionesAno->id) ?></td>
                <td><?= $observacionesAno->has('student') ? $this->Html->link($observacionesAno->student->full_name, ['controller' => 'Students', 'action' => 'view', $observacionesAno->student->id]) : '' ?></td>
                <td><?= h($observacionesAno->periodo_escolar) ?></td>
                <td><?= h($observacionesAno->tipo_observacion) ?></td>
                <td><?= h($observacionesAno->registro_eliminado) ?></td>
                <td><?= h($observacionesAno->created) ?></td>
                <td><?= h($observacionesAno->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $observacionesAno->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $observacionesAno->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $observacionesAno->id], ['confirm' => __('Are you sure you want to delete # {0}?', $observacionesAno->id)]) ?>
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
