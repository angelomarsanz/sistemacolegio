<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Objetivo'), ['action' => 'edit', $objetivo->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Objetivo'), ['action' => 'delete', $objetivo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $objetivo->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Objetivos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Objetivo'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Materias'), ['controller' => 'Materias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Materia'), ['controller' => 'Materias', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Profesors'), ['controller' => 'Profesors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Profesor'), ['controller' => 'Profesors', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Calificacions'), ['controller' => 'Calificacions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Calificacion'), ['controller' => 'Calificacions', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="objetivos view large-9 medium-8 columns content">
    <h3><?= h($objetivo->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Lapso') ?></th>
            <td><?= $objetivo->has('lapso') ? $this->Html->link($objetivo->lapso->id, ['controller' => 'Lapsos', 'action' => 'view', $objetivo->lapso->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Materia') ?></th>
            <td><?= $objetivo->has('materia') ? $this->Html->link($objetivo->materia->id, ['controller' => 'Materias', 'action' => 'view', $objetivo->materia->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Profesor') ?></th>
            <td><?= $objetivo->has('profesor') ? $this->Html->link($objetivo->profesor->id, ['controller' => 'Profesors', 'action' => 'view', $objetivo->profesor->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Descripcion Objetivo') ?></th>
            <td><?= h($objetivo->descripcion_objetivo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Instrumento Objetivo') ?></th>
            <td><?= h($objetivo->instrumento_objetivo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Comentario Objetivo') ?></th>
            <td><?= h($objetivo->comentario_objetivo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($objetivo->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Numero Objetivo') ?></th>
            <td><?= $this->Number->format($objetivo->numero_objetivo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ponderacion Objetivo') ?></th>
            <td><?= $this->Number->format($objetivo->ponderacion_objetivo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha Objetivo') ?></th>
            <td><?= h($objetivo->fecha_objetivo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($objetivo->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($objetivo->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registro Eliminado') ?></th>
            <td><?= $objetivo->registro_eliminado ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Calificacions') ?></h4>
        <?php if (!empty($objetivo->calificacions)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Objetivo Id') ?></th>
                <th scope="col"><?= __('Student Id') ?></th>
                <th scope="col"><?= __('Puntaje') ?></th>
                <th scope="col"><?= __('Puntaje 112') ?></th>
                <th scope="col"><?= __('Registro Eliminado') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($objetivo->calificacions as $calificacions): ?>
            <tr>
                <td><?= h($calificacions->id) ?></td>
                <td><?= h($calificacions->objetivo_id) ?></td>
                <td><?= h($calificacions->student_id) ?></td>
                <td><?= h($calificacions->puntaje) ?></td>
                <td><?= h($calificacions->puntaje_112) ?></td>
                <td><?= h($calificacions->registro_eliminado) ?></td>
                <td><?= h($calificacions->created) ?></td>
                <td><?= h($calificacions->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Calificacions', 'action' => 'view', $calificacions->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Calificacions', 'action' => 'edit', $calificacions->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Calificacions', 'action' => 'delete', $calificacions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $calificacions->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
