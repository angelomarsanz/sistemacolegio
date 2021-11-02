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
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('section_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nombre_profesor') ?></th>
                <th scope="col"><?= $this->Paginator->sort('descripcion_profesor') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cantidad_horas_semanales') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($profesors as $profesor): ?>
            <tr>
                <td><?= $this->Number->format($profesor->id) ?></td>
                <td><?= h($profesor->section_id) ?></td>
                <td><?= h($profesor->nombre_profesor) ?></td>
                <td><?= h($profesor->descripcion_profesor) ?></td>
                <td><?= h($profesor->cantidad_horas_semanales) ?></td>
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