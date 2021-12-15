<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Rasgos Personalidad'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Materias'), ['controller' => 'Materias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Materia'), ['controller' => 'Materias', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Opciones Usuarios'), ['controller' => 'OpcionesUsuarios', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Opciones Usuario'), ['controller' => 'OpcionesUsuarios', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="rasgosPersonalidads index large-9 medium-8 columns content">
    <h3><?= __('Rasgos Personalidads') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lapso_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('materia_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('student_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('opciones_usuario_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('calificacion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('registro_eliminado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rasgosPersonalidads as $rasgosPersonalidad): ?>
            <tr>
                <td><?= $this->Number->format($rasgosPersonalidad->id) ?></td>
                <td><?= $rasgosPersonalidad->has('lapso') ? $this->Html->link($rasgosPersonalidad->lapso->id, ['controller' => 'Lapsos', 'action' => 'view', $rasgosPersonalidad->lapso->id]) : '' ?></td>
                <td><?= $rasgosPersonalidad->has('materia') ? $this->Html->link($rasgosPersonalidad->materia->id, ['controller' => 'Materias', 'action' => 'view', $rasgosPersonalidad->materia->id]) : '' ?></td>
                <td><?= $rasgosPersonalidad->has('student') ? $this->Html->link($rasgosPersonalidad->student->full_name, ['controller' => 'Students', 'action' => 'view', $rasgosPersonalidad->student->id]) : '' ?></td>
                <td><?= $rasgosPersonalidad->has('opciones_usuario') ? $this->Html->link($rasgosPersonalidad->opciones_usuario->id, ['controller' => 'OpcionesUsuarios', 'action' => 'view', $rasgosPersonalidad->opciones_usuario->id]) : '' ?></td>
                <td><?= h($rasgosPersonalidad->calificacion) ?></td>
                <td><?= h($rasgosPersonalidad->registro_eliminado) ?></td>
                <td><?= h($rasgosPersonalidad->created) ?></td>
                <td><?= h($rasgosPersonalidad->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $rasgosPersonalidad->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $rasgosPersonalidad->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $rasgosPersonalidad->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rasgosPersonalidad->id)]) ?>
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
