<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Rasgos Personalidad'), ['action' => 'edit', $rasgosPersonalidad->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Rasgos Personalidad'), ['action' => 'delete', $rasgosPersonalidad->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rasgosPersonalidad->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Rasgos Personalidads'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Rasgos Personalidad'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Materias'), ['controller' => 'Materias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Materia'), ['controller' => 'Materias', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Opciones Usuarios'), ['controller' => 'OpcionesUsuarios', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Opciones Usuario'), ['controller' => 'OpcionesUsuarios', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="rasgosPersonalidads view large-9 medium-8 columns content">
    <h3><?= h($rasgosPersonalidad->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Lapso') ?></th>
            <td><?= $rasgosPersonalidad->has('lapso') ? $this->Html->link($rasgosPersonalidad->lapso->id, ['controller' => 'Lapsos', 'action' => 'view', $rasgosPersonalidad->lapso->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Materia') ?></th>
            <td><?= $rasgosPersonalidad->has('materia') ? $this->Html->link($rasgosPersonalidad->materia->id, ['controller' => 'Materias', 'action' => 'view', $rasgosPersonalidad->materia->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Student') ?></th>
            <td><?= $rasgosPersonalidad->has('student') ? $this->Html->link($rasgosPersonalidad->student->full_name, ['controller' => 'Students', 'action' => 'view', $rasgosPersonalidad->student->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Opciones Usuario') ?></th>
            <td><?= $rasgosPersonalidad->has('opciones_usuario') ? $this->Html->link($rasgosPersonalidad->opciones_usuario->id, ['controller' => 'OpcionesUsuarios', 'action' => 'view', $rasgosPersonalidad->opciones_usuario->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Calificacion') ?></th>
            <td><?= h($rasgosPersonalidad->calificacion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($rasgosPersonalidad->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($rasgosPersonalidad->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($rasgosPersonalidad->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registro Eliminado') ?></th>
            <td><?= $rasgosPersonalidad->registro_eliminado ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
