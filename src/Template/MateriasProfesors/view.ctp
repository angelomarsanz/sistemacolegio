<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Materias Profesor'), ['action' => 'edit', $materiasProfesor->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Materias Profesor'), ['action' => 'delete', $materiasProfesor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $materiasProfesor->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Materias Profesors'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Materias Profesor'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Materias'), ['controller' => 'Materias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Materia'), ['controller' => 'Materias', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Profesors'), ['controller' => 'Profesors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Profesor'), ['controller' => 'Profesors', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="materiasProfesors view large-9 medium-8 columns content">
    <h3><?= h($materiasProfesor->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Materia') ?></th>
            <td><?= $materiasProfesor->has('materia') ? $this->Html->link($materiasProfesor->materia->id, ['controller' => 'Materias', 'action' => 'view', $materiasProfesor->materia->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Profesor') ?></th>
            <td><?= $materiasProfesor->has('profesor') ? $this->Html->link($materiasProfesor->profesor->id, ['controller' => 'Profesors', 'action' => 'view', $materiasProfesor->profesor->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($materiasProfesor->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($materiasProfesor->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($materiasProfesor->modified) ?></td>
        </tr>
    </table>
</div>
