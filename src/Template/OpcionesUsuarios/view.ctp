<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Opciones Usuario'), ['action' => 'edit', $opcionesUsuario->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Opciones Usuario'), ['action' => 'delete', $opcionesUsuario->id], ['confirm' => __('Are you sure you want to delete # {0}?', $opcionesUsuario->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Opciones Usuarios'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Opciones Usuario'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Materias'), ['controller' => 'Materias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Materia'), ['controller' => 'Materias', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Rasgos Personalidads'), ['controller' => 'RasgosPersonalidads', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Rasgos Personalidad'), ['controller' => 'RasgosPersonalidads', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="opcionesUsuarios view large-9 medium-8 columns content">
    <h3><?= h($opcionesUsuario->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $opcionesUsuario->has('user') ? $this->Html->link($opcionesUsuario->user->id, ['controller' => 'Users', 'action' => 'view', $opcionesUsuario->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lapso') ?></th>
            <td><?= $opcionesUsuario->has('lapso') ? $this->Html->link($opcionesUsuario->lapso->id, ['controller' => 'Lapsos', 'action' => 'view', $opcionesUsuario->lapso->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Materia') ?></th>
            <td><?= $opcionesUsuario->has('materia') ? $this->Html->link($opcionesUsuario->materia->id, ['controller' => 'Materias', 'action' => 'view', $opcionesUsuario->materia->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipo Opcion') ?></th>
            <td><?= h($opcionesUsuario->tipo_opcion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Descripcion Opcion') ?></th>
            <td><?= h($opcionesUsuario->descripcion_opcion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($opcionesUsuario->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($opcionesUsuario->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($opcionesUsuario->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registro Eliminado') ?></th>
            <td><?= $opcionesUsuario->registro_eliminado ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Rasgos Personalidads') ?></h4>
        <?php if (!empty($opcionesUsuario->rasgos_personalidads)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Lapso Id') ?></th>
                <th scope="col"><?= __('Materia Id') ?></th>
                <th scope="col"><?= __('Student Id') ?></th>
                <th scope="col"><?= __('Opciones Usuario Id') ?></th>
                <th scope="col"><?= __('Calificacion') ?></th>
                <th scope="col"><?= __('Registro Eliminado') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($opcionesUsuario->rasgos_personalidads as $rasgosPersonalidads): ?>
            <tr>
                <td><?= h($rasgosPersonalidads->id) ?></td>
                <td><?= h($rasgosPersonalidads->lapso_id) ?></td>
                <td><?= h($rasgosPersonalidads->materia_id) ?></td>
                <td><?= h($rasgosPersonalidads->student_id) ?></td>
                <td><?= h($rasgosPersonalidads->opciones_usuario_id) ?></td>
                <td><?= h($rasgosPersonalidads->calificacion) ?></td>
                <td><?= h($rasgosPersonalidads->registro_eliminado) ?></td>
                <td><?= h($rasgosPersonalidads->created) ?></td>
                <td><?= h($rasgosPersonalidads->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'RasgosPersonalidads', 'action' => 'view', $rasgosPersonalidads->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'RasgosPersonalidads', 'action' => 'edit', $rasgosPersonalidads->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'RasgosPersonalidads', 'action' => 'delete', $rasgosPersonalidads->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rasgosPersonalidads->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
