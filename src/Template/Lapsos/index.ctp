<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Lapso'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Estudiante Lapsos'), ['controller' => 'EstudianteLapsos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Estudiante Lapso'), ['controller' => 'EstudianteLapsos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Literal Lapsos'), ['controller' => 'LiteralLapsos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Literal Lapso'), ['controller' => 'LiteralLapsos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Literal Materias'), ['controller' => 'LiteralMaterias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Literal Materia'), ['controller' => 'LiteralMaterias', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Objetivos'), ['controller' => 'Objetivos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Objetivo'), ['controller' => 'Objetivos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Observacions'), ['controller' => 'Observacions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Observacion'), ['controller' => 'Observacions', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Parametros Carga Calificacions'), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Parametros Carga Calificacion'), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Prueba Lapsos'), ['controller' => 'PruebaLapsos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Prueba Lapso'), ['controller' => 'PruebaLapsos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="lapsos index large-9 medium-8 columns content">
    <h3><?= __('Lapsos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('periodo_escolar') ?></th>
                <th scope="col"><?= $this->Paginator->sort('numero_lapso') ?></th>
                <th scope="col"><?= $this->Paginator->sort('registro_eliminado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lapsos as $lapso): ?>
            <tr>
                <td><?= $this->Number->format($lapso->id) ?></td>
                <td><?= h($lapso->periodo_escolar) ?></td>
                <td><?= $this->Number->format($lapso->numero_lapso) ?></td>
                <td><?= h($lapso->registro_eliminado) ?></td>
                <td><?= h($lapso->created) ?></td>
                <td><?= h($lapso->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $lapso->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $lapso->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $lapso->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lapso->id)]) ?>
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
