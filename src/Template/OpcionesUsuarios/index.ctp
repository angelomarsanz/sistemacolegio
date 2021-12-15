<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Opciones Usuario'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Materias'), ['controller' => 'Materias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Materia'), ['controller' => 'Materias', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Rasgos Personalidads'), ['controller' => 'RasgosPersonalidads', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Rasgos Personalidad'), ['controller' => 'RasgosPersonalidads', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="opcionesUsuarios index large-9 medium-8 columns content">
    <h3><?= __('Opciones Usuarios') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lapso_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('materia_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tipo_opcion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('descripcion_opcion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('registro_eliminado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($opcionesUsuarios as $opcionesUsuario): ?>
            <tr>
                <td><?= $this->Number->format($opcionesUsuario->id) ?></td>
                <td><?= $opcionesUsuario->has('user') ? $this->Html->link($opcionesUsuario->user->id, ['controller' => 'Users', 'action' => 'view', $opcionesUsuario->user->id]) : '' ?></td>
                <td><?= $opcionesUsuario->has('lapso') ? $this->Html->link($opcionesUsuario->lapso->id, ['controller' => 'Lapsos', 'action' => 'view', $opcionesUsuario->lapso->id]) : '' ?></td>
                <td><?= $opcionesUsuario->has('materia') ? $this->Html->link($opcionesUsuario->materia->id, ['controller' => 'Materias', 'action' => 'view', $opcionesUsuario->materia->id]) : '' ?></td>
                <td><?= h($opcionesUsuario->tipo_opcion) ?></td>
                <td><?= h($opcionesUsuario->descripcion_opcion) ?></td>
                <td><?= h($opcionesUsuario->registro_eliminado) ?></td>
                <td><?= h($opcionesUsuario->created) ?></td>
                <td><?= h($opcionesUsuario->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $opcionesUsuario->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $opcionesUsuario->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $opcionesUsuario->id], ['confirm' => __('Are you sure you want to delete # {0}?', $opcionesUsuario->id)]) ?>
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
