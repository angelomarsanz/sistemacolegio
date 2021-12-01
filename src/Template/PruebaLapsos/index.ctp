<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Prueba Lapso'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Materias'), ['controller' => 'Materias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Materia'), ['controller' => 'Materias', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="pruebaLapsos index large-9 medium-8 columns content">
    <h3><?= __('Prueba Lapsos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lapso_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('materia_id') ?></th>
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
            <?php foreach ($pruebaLapsos as $pruebaLapso): ?>
            <tr>
                <td><?= $this->Number->format($pruebaLapso->id) ?></td>
                <td><?= $pruebaLapso->has('lapso') ? $this->Html->link($pruebaLapso->lapso->id, ['controller' => 'Lapsos', 'action' => 'view', $pruebaLapso->lapso->id]) : '' ?></td>
                <td><?= $pruebaLapso->has('materia') ? $this->Html->link($pruebaLapso->materia->id, ['controller' => 'Materias', 'action' => 'view', $pruebaLapso->materia->id]) : '' ?></td>
                <td><?= $pruebaLapso->has('student') ? $this->Html->link($pruebaLapso->student->full_name, ['controller' => 'Students', 'action' => 'view', $pruebaLapso->student->id]) : '' ?></td>
                <td><?= $this->Number->format($pruebaLapso->puntaje) ?></td>
                <td><?= $this->Number->format($pruebaLapso->puntaje_112) ?></td>
                <td><?= h($pruebaLapso->registro_eliminado) ?></td>
                <td><?= h($pruebaLapso->created) ?></td>
                <td><?= h($pruebaLapso->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $pruebaLapso->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pruebaLapso->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pruebaLapso->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pruebaLapso->id)]) ?>
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
