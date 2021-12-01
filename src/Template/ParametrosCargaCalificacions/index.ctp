<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Parametros Carga Calificacion'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Profesors'), ['controller' => 'Profesors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Profesor'), ['controller' => 'Profesors', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Materias'), ['controller' => 'Materias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Materia'), ['controller' => 'Materias', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sections'), ['controller' => 'Sections', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Section'), ['controller' => 'Sections', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="parametrosCargaCalificacions index large-9 medium-8 columns content">
    <h3><?= __('Parametros Carga Calificacions') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('profesor_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lapso_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('materia_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('section_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('registro_eliminado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($parametrosCargaCalificacions as $parametrosCargaCalificacion): ?>
            <tr>
                <td><?= $this->Number->format($parametrosCargaCalificacion->id) ?></td>
                <td><?= $parametrosCargaCalificacion->has('profesor') ? $this->Html->link($parametrosCargaCalificacion->profesor->id, ['controller' => 'Profesors', 'action' => 'view', $parametrosCargaCalificacion->profesor->id]) : '' ?></td>
                <td><?= $parametrosCargaCalificacion->has('lapso') ? $this->Html->link($parametrosCargaCalificacion->lapso->id, ['controller' => 'Lapsos', 'action' => 'view', $parametrosCargaCalificacion->lapso->id]) : '' ?></td>
                <td><?= $parametrosCargaCalificacion->has('materia') ? $this->Html->link($parametrosCargaCalificacion->materia->id, ['controller' => 'Materias', 'action' => 'view', $parametrosCargaCalificacion->materia->id]) : '' ?></td>
                <td><?= $parametrosCargaCalificacion->has('section') ? $this->Html->link($parametrosCargaCalificacion->section->full_name, ['controller' => 'Sections', 'action' => 'view', $parametrosCargaCalificacion->section->id]) : '' ?></td>
                <td><?= h($parametrosCargaCalificacion->registro_eliminado) ?></td>
                <td><?= h($parametrosCargaCalificacion->created) ?></td>
                <td><?= h($parametrosCargaCalificacion->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $parametrosCargaCalificacion->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $parametrosCargaCalificacion->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $parametrosCargaCalificacion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $parametrosCargaCalificacion->id)]) ?>
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
