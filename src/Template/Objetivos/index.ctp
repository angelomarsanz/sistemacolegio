<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Objetivo'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Materias'), ['controller' => 'Materias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Materia'), ['controller' => 'Materias', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Profesors'), ['controller' => 'Profesors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Profesor'), ['controller' => 'Profesors', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Calificacions'), ['controller' => 'Calificacions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Calificacion'), ['controller' => 'Calificacions', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="objetivos index large-9 medium-8 columns content">
    <h3><?= __('Objetivos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lapso_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('materia_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('profesor_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('numero_objetivo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fecha_objetivo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('descripcion_objetivo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('instrumento_objetivo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ponderacion_objetivo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('comentario_objetivo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('registro_eliminado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($objetivos as $objetivo): ?>
            <tr>
                <td><?= $this->Number->format($objetivo->id) ?></td>
                <td><?= $objetivo->has('lapso') ? $this->Html->link($objetivo->lapso->id, ['controller' => 'Lapsos', 'action' => 'view', $objetivo->lapso->id]) : '' ?></td>
                <td><?= $objetivo->has('materia') ? $this->Html->link($objetivo->materia->id, ['controller' => 'Materias', 'action' => 'view', $objetivo->materia->id]) : '' ?></td>
                <td><?= $objetivo->has('profesor') ? $this->Html->link($objetivo->profesor->id, ['controller' => 'Profesors', 'action' => 'view', $objetivo->profesor->id]) : '' ?></td>
                <td><?= $this->Number->format($objetivo->numero_objetivo) ?></td>
                <td><?= h($objetivo->fecha_objetivo) ?></td>
                <td><?= h($objetivo->descripcion_objetivo) ?></td>
                <td><?= h($objetivo->instrumento_objetivo) ?></td>
                <td><?= $this->Number->format($objetivo->ponderacion_objetivo) ?></td>
                <td><?= h($objetivo->comentario_objetivo) ?></td>
                <td><?= h($objetivo->registro_eliminado) ?></td>
                <td><?= h($objetivo->created) ?></td>
                <td><?= h($objetivo->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $objetivo->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $objetivo->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $objetivo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $objetivo->id)]) ?>
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
