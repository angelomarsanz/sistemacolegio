<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Materia'), ['action' => 'edit', $materia->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Materia'), ['action' => 'delete', $materia->id], ['confirm' => __('Are you sure you want to delete # {0}?', $materia->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Materias'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Materia'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="materias view large-9 medium-8 columns content">
    <h3><?= h($materia->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nombre Materia') ?></th>
            <td><?= h($materia->nombre_materia) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Descripcion Materia') ?></th>
            <td><?= h($materia->descripcion_materia) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cantidad Horas Semanales') ?></th>
            <td><?= h($materia->cantidad_horas_semanales) ?></td>
        </tr>
    </table>
</div>