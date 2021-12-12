<br />
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Modificar objetivo'), ['action' => 'edit', $objetivo->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Eliminar objetivo'), ['action' => 'delete', $objetivo->id], ['confirm' => __('Está usted seguro que desea eliminar el objetivo # {0}?', $objetivo->numer_objetivo)]) ?> </li>
        <li><?= $this->Html->link(__('Agregar nuevo objetivo'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="objetivos view large-9 medium-8 columns content">
    <h5>Identificador <?= h($objetivo->id) ?></h5>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Lapso') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= $objetivo->has('lapso') ? $this->Html->link($objetivo->lapso->numero_lapso, ['controller' => 'Lapsos', 'action' => 'view', $objetivo->lapso->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Materia') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= $objetivo->has('materia') ? $this->Html->link($objetivo->materia->full_name, ['controller' => 'Materias', 'action' => 'view', $objetivo->materia->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Profesor') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= $objetivo->has('profesor') ? $this->Html->link($objetivo->profesor->primer_apellido . ' ' . $objetivo->profesor->primer_nombre, ['controller' => 'Profesors', 'action' => 'view', $objetivo->profesor->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Objetivo') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= $objetivo->objetivo ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?php $objetivo->fecha_objetivo != null ? $objetivo->fecha_objetivo->format('d-m-Y') : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Descripcion') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= h($objetivo->descripcion_objetivo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Instrumento') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= h($objetivo->instrumento_objetivo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ponderacion (%)') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= $this->Number->format($objetivo->ponderacion_objetivo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Observacion') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= h($objetivo->comentario_objetivo) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Calificaciones relacionadas') ?></h4>
        <?php if (!empty($objetivo->calificacions)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Estudiante') ?>&nbsp;&nbsp;&nbsp;</th>
                <th scope="col"><?= __('Puntaje') ?>&nbsp;&nbsp;&nbsp;</th>
                <th scope="col"><?= __('Puntaje 112') ?>&nbsp;&nbsp;&nbsp;</th>
                <th scope="col" class="actions"><?= __('Acciones') ?></th>
            </tr>
            <?php foreach ($objetivo->calificacions as $calificacions): ?>
            <tr>
                <td><?= h($calificacions->student->surname . ' ' . $calificacions->student->first_name) ?>&nbsp;&nbsp;&nbsp;</td>
                <td><?= h($calificacions->puntaje) ?>&nbsp;&nbsp;&nbsp;</td>
                <td><?= h($calificacions->puntaje_112) ?>&nbsp;&nbsp;&nbsp;</td>
                <td class="actions">
                    <?= $this->Html->link(__('Ver'), ['controller' => 'Calificacions', 'action' => 'view', $calificacions->id]) ?>
                    <?= $this->Html->link(__('Modificar'), ['controller' => 'Calificacions', 'action' => 'edit', $calificacions->id]) ?>
                    <?= $this->Form->postLink(__('Eliminar'), ['controller' => 'Calificacions', 'action' => 'delete', $calificacions->id], ['confirm' => __('Está seguro que usted desea eliminar la calificación del estudiante {0}?', $calificacions->student->surname . ' ' . $calificacions->student->first_name)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
