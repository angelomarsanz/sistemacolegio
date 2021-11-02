<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Profesor'), ['action' => 'edit', $profesor->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Profesor'), ['action' => 'delete', $profesor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $profesor->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Profesors'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Profesor'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="profesors view large-9 medium-8 columns content">
    <h3><?= h($profesor->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nombre Profesor') ?></th>
            <td><?= h($profesor->nombre_profesor) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Descripcion Profesor') ?></th>
            <td><?= h($profesor->descripcion_profesor) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cantidad Horas Semanales') ?></th>
            <td><?= h($profesor->cantidad_horas_semanales) ?></td>
        </tr>
    </table>
</div>