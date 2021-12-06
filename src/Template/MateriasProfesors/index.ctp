<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Materias Profesor'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Materias'), ['controller' => 'Materias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Materia'), ['controller' => 'Materias', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Profesors'), ['controller' => 'Profesors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Profesor'), ['controller' => 'Profesors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="materiasProfesors index large-9 medium-8 columns content">
    <h3><?= __('Materias Profesors') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('materia_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('profesor_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($materiasProfesors as $materiasProfesor): ?>
            <tr>
                <td><?= $this->Number->format($materiasProfesor->id) ?></td>
                <td><?= $materiasProfesor->has('materia') ? $this->Html->link($materiasProfesor->materia->id, ['controller' => 'Materias', 'action' => 'view', $materiasProfesor->materia->id]) : '' ?></td>
                <td><?= $materiasProfesor->has('profesor') ? $this->Html->link($materiasProfesor->profesor->id, ['controller' => 'Profesors', 'action' => 'view', $materiasProfesor->profesor->id]) : '' ?></td>
                <td><?= h($materiasProfesor->created) ?></td>
                <td><?= h($materiasProfesor->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $materiasProfesor->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $materiasProfesor->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $materiasProfesor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $materiasProfesor->id)]) ?>
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
