<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Acciones') ?></li>
        <li><?= $this->Html->link(__('Lista de materias'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Agregar una nueva materia'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Modificar la materia'), ['action' => 'edit', $materia->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Eliminar la Materia'), ['action' => 'delete', $materia->id], ['confirm' => __('Are you sure you want to delete # {0}?', $materia->id)]) ?> </li>
    </ul>
</nav>
<div class="materias view large-9 medium-8 columns content">
    <h5>Identificador: <?= h($materia->id) ?>&nbsp;&nbsp;&nbsp;</h5>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nombre:') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= h($materia->nombre_materia) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Descripcion:') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= h($materia->descripcion_materia) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cantidad de horas semanales:') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= h($materia->cantidad_horas_semanales) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Profesores que dictan esta materia') ?></h4>
        <?php if (!empty($profesoresMateria)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Nombre') ?>&nbsp;&nbsp;&nbsp;</th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($profesoresMateria as $profesoresMat): ?>
            <tr>
                <td><?= h($profesoresMat->profesor->primer_apellido . ' ' . $profesoresMat->profesor->primer_nombre) ?>&nbsp;&nbsp;&nbsp;</td>
                <td class="actions">
                    <?= $this->Html->link(__('Ver'), ['controller' => 'Profesors', 'action' => 'view', $profesoresMat->profesor->id]) ?>
                    <?= $this->Html->link(__('Modificar'), ['controller' => 'Profesors', 'action' => 'edit', $profesoresMat->profesor->id]) ?>
                    <?= $this->Form->postLink(__('Eliminar'), ['controller' => 'Profesors', 'action' => 'delete', $profesoresMat->profesor->id], ['confirm' => __('Está seguro de que desea eliminar este profesor {0}?', $profesoresMat->profesor->full_name)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>