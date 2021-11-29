<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Materia'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="materias index large-9 medium-8 columns content">
    <h3><?= __('Materias') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('section_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nombre_materia') ?></th>
                <th scope="col"><?= $this->Paginator->sort('descripcion_materia') ?></th>
                <th scope="col"><?= $this->Paginator->sort('grado_materia') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cantidad_horas_semanales') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($materias as $materia): ?>
            <tr>
                <td><?= $this->Number->format($materia->id) ?></td>
                <td><?= h($materia->section_id) ?></td>
                <td><?= h($materia->nombre_materia) ?></td>
                <td><?= h($materia->descripcion_materia) ?></td>
                <td><?= h($materia->grado_materia) ?></td>
                <td><?= h($materia->cantidad_horas_semanales) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $materia->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $materia->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $materia->id], ['confirm' => __('Are you sure you want to delete # {0}?', $materia->id)]) ?>
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