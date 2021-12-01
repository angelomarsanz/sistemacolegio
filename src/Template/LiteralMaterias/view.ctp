<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Literal Materia'), ['action' => 'edit', $literalMateria->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Literal Materia'), ['action' => 'delete', $literalMateria->id], ['confirm' => __('Are you sure you want to delete # {0}?', $literalMateria->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Literal Materias'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Literal Materia'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Materias'), ['controller' => 'Materias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Materia'), ['controller' => 'Materias', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="literalMaterias view large-9 medium-8 columns content">
    <h3><?= h($literalMateria->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Lapso') ?></th>
            <td><?= $literalMateria->has('lapso') ? $this->Html->link($literalMateria->lapso->id, ['controller' => 'Lapsos', 'action' => 'view', $literalMateria->lapso->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Materia') ?></th>
            <td><?= $literalMateria->has('materia') ? $this->Html->link($literalMateria->materia->id, ['controller' => 'Materias', 'action' => 'view', $literalMateria->materia->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Student') ?></th>
            <td><?= $literalMateria->has('student') ? $this->Html->link($literalMateria->student->full_name, ['controller' => 'Students', 'action' => 'view', $literalMateria->student->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Literal') ?></th>
            <td><?= h($literalMateria->literal) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($literalMateria->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($literalMateria->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($literalMateria->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registro Eliminado') ?></th>
            <td><?= $literalMateria->registro_eliminado ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Calificacion Descriptiva') ?></h4>
        <?= $this->Text->autoParagraph(h($literalMateria->calificacion_descriptiva)); ?>
    </div>
</div>
