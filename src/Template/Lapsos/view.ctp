<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Lapso'), ['action' => 'edit', $lapso->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Lapso'), ['action' => 'delete', $lapso->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lapso->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Lapsos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Lapso'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Estudiante Lapsos'), ['controller' => 'EstudianteLapsos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Estudiante Lapso'), ['controller' => 'EstudianteLapsos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Literal Lapsos'), ['controller' => 'LiteralLapsos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Literal Lapso'), ['controller' => 'LiteralLapsos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Literal Materias'), ['controller' => 'LiteralMaterias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Literal Materia'), ['controller' => 'LiteralMaterias', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Objetivos'), ['controller' => 'Objetivos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Objetivo'), ['controller' => 'Objetivos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Observacions'), ['controller' => 'Observacions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Observacion'), ['controller' => 'Observacions', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parametros Carga Calificacions'), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Parametros Carga Calificacion'), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Prueba Lapsos'), ['controller' => 'PruebaLapsos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Prueba Lapso'), ['controller' => 'PruebaLapsos', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="lapsos view large-9 medium-8 columns content">
    <h3><?= h($lapso->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Periodo Escolar') ?></th>
            <td><?= h($lapso->periodo_escolar) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($lapso->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Numero Lapso') ?></th>
            <td><?= $this->Number->format($lapso->numero_lapso) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($lapso->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($lapso->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registro Eliminado') ?></th>
            <td><?= $lapso->registro_eliminado ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Estudiante Lapsos') ?></h4>
        <?php if (!empty($lapso->estudiante_lapsos)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Student Id') ?></th>
                <th scope="col"><?= __('Lapso Id') ?></th>
                <th scope="col"><?= __('Materia Id') ?></th>
                <th scope="col"><?= __('Registro Eliminado') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($lapso->estudiante_lapsos as $estudianteLapsos): ?>
            <tr>
                <td><?= h($estudianteLapsos->id) ?></td>
                <td><?= h($estudianteLapsos->student_id) ?></td>
                <td><?= h($estudianteLapsos->lapso_id) ?></td>
                <td><?= h($estudianteLapsos->materia_id) ?></td>
                <td><?= h($estudianteLapsos->registro_eliminado) ?></td>
                <td><?= h($estudianteLapsos->created) ?></td>
                <td><?= h($estudianteLapsos->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'EstudianteLapsos', 'action' => 'view', $estudianteLapsos->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'EstudianteLapsos', 'action' => 'edit', $estudianteLapsos->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'EstudianteLapsos', 'action' => 'delete', $estudianteLapsos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estudianteLapsos->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Literal Lapsos') ?></h4>
        <?php if (!empty($lapso->literal_lapsos)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Lapso Id') ?></th>
                <th scope="col"><?= __('Student Id') ?></th>
                <th scope="col"><?= __('Calificacion Descriptiva') ?></th>
                <th scope="col"><?= __('Literal') ?></th>
                <th scope="col"><?= __('Registro Eliminado') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($lapso->literal_lapsos as $literalLapsos): ?>
            <tr>
                <td><?= h($literalLapsos->id) ?></td>
                <td><?= h($literalLapsos->lapso_id) ?></td>
                <td><?= h($literalLapsos->student_id) ?></td>
                <td><?= h($literalLapsos->calificacion_descriptiva) ?></td>
                <td><?= h($literalLapsos->literal) ?></td>
                <td><?= h($literalLapsos->registro_eliminado) ?></td>
                <td><?= h($literalLapsos->created) ?></td>
                <td><?= h($literalLapsos->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'LiteralLapsos', 'action' => 'view', $literalLapsos->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'LiteralLapsos', 'action' => 'edit', $literalLapsos->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'LiteralLapsos', 'action' => 'delete', $literalLapsos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $literalLapsos->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Literal Materias') ?></h4>
        <?php if (!empty($lapso->literal_materias)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Lapso Id') ?></th>
                <th scope="col"><?= __('Materia Id') ?></th>
                <th scope="col"><?= __('Student Id') ?></th>
                <th scope="col"><?= __('Calificacion Descriptiva') ?></th>
                <th scope="col"><?= __('Literal') ?></th>
                <th scope="col"><?= __('Registro Eliminado') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($lapso->literal_materias as $literalMaterias): ?>
            <tr>
                <td><?= h($literalMaterias->id) ?></td>
                <td><?= h($literalMaterias->lapso_id) ?></td>
                <td><?= h($literalMaterias->materia_id) ?></td>
                <td><?= h($literalMaterias->student_id) ?></td>
                <td><?= h($literalMaterias->calificacion_descriptiva) ?></td>
                <td><?= h($literalMaterias->literal) ?></td>
                <td><?= h($literalMaterias->registro_eliminado) ?></td>
                <td><?= h($literalMaterias->created) ?></td>
                <td><?= h($literalMaterias->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'LiteralMaterias', 'action' => 'view', $literalMaterias->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'LiteralMaterias', 'action' => 'edit', $literalMaterias->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'LiteralMaterias', 'action' => 'delete', $literalMaterias->id], ['confirm' => __('Are you sure you want to delete # {0}?', $literalMaterias->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Objetivos') ?></h4>
        <?php if (!empty($lapso->objetivos)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Lapso Id') ?></th>
                <th scope="col"><?= __('Materia Id') ?></th>
                <th scope="col"><?= __('Profesor Id') ?></th>
                <th scope="col"><?= __('Numero Objetivo') ?></th>
                <th scope="col"><?= __('Fecha Objetivo') ?></th>
                <th scope="col"><?= __('Descripcion Objetivo') ?></th>
                <th scope="col"><?= __('Instrumento Objetivo') ?></th>
                <th scope="col"><?= __('Ponderacion Objetivo') ?></th>
                <th scope="col"><?= __('Comentario Objetivo') ?></th>
                <th scope="col"><?= __('Registro Eliminado') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($lapso->objetivos as $objetivos): ?>
            <tr>
                <td><?= h($objetivos->id) ?></td>
                <td><?= h($objetivos->lapso_id) ?></td>
                <td><?= h($objetivos->materia_id) ?></td>
                <td><?= h($objetivos->profesor_id) ?></td>
                <td><?= h($objetivos->numero_objetivo) ?></td>
                <td><?= h($objetivos->fecha_objetivo) ?></td>
                <td><?= h($objetivos->descripcion_objetivo) ?></td>
                <td><?= h($objetivos->instrumento_objetivo) ?></td>
                <td><?= h($objetivos->ponderacion_objetivo) ?></td>
                <td><?= h($objetivos->comentario_objetivo) ?></td>
                <td><?= h($objetivos->registro_eliminado) ?></td>
                <td><?= h($objetivos->created) ?></td>
                <td><?= h($objetivos->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Objetivos', 'action' => 'view', $objetivos->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Objetivos', 'action' => 'edit', $objetivos->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Objetivos', 'action' => 'delete', $objetivos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $objetivos->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Observacions') ?></h4>
        <?php if (!empty($lapso->observacions)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Lapso Id') ?></th>
                <th scope="col"><?= __('Student Id') ?></th>
                <th scope="col"><?= __('Observacion') ?></th>
                <th scope="col"><?= __('Registro Elimindo') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($lapso->observacions as $observacions): ?>
            <tr>
                <td><?= h($observacions->id) ?></td>
                <td><?= h($observacions->lapso_id) ?></td>
                <td><?= h($observacions->student_id) ?></td>
                <td><?= h($observacions->observacion) ?></td>
                <td><?= h($observacions->registro_elimindo) ?></td>
                <td><?= h($observacions->created) ?></td>
                <td><?= h($observacions->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Observacions', 'action' => 'view', $observacions->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Observacions', 'action' => 'edit', $observacions->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Observacions', 'action' => 'delete', $observacions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $observacions->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Parametros Carga Calificacions') ?></h4>
        <?php if (!empty($lapso->parametros_carga_calificacions)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Profesor Id') ?></th>
                <th scope="col"><?= __('Lapso Id') ?></th>
                <th scope="col"><?= __('Materia Id') ?></th>
                <th scope="col"><?= __('Section Id') ?></th>
                <th scope="col"><?= __('Registro Eliminado') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($lapso->parametros_carga_calificacions as $parametrosCargaCalificacions): ?>
            <tr>
                <td><?= h($parametrosCargaCalificacions->id) ?></td>
                <td><?= h($parametrosCargaCalificacions->profesor_id) ?></td>
                <td><?= h($parametrosCargaCalificacions->lapso_id) ?></td>
                <td><?= h($parametrosCargaCalificacions->materia_id) ?></td>
                <td><?= h($parametrosCargaCalificacions->section_id) ?></td>
                <td><?= h($parametrosCargaCalificacions->registro_eliminado) ?></td>
                <td><?= h($parametrosCargaCalificacions->created) ?></td>
                <td><?= h($parametrosCargaCalificacions->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'view', $parametrosCargaCalificacions->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'edit', $parametrosCargaCalificacions->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'delete', $parametrosCargaCalificacions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $parametrosCargaCalificacions->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Prueba Lapsos') ?></h4>
        <?php if (!empty($lapso->prueba_lapsos)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Lapso Id') ?></th>
                <th scope="col"><?= __('Materia Id') ?></th>
                <th scope="col"><?= __('Student Id') ?></th>
                <th scope="col"><?= __('Puntaje') ?></th>
                <th scope="col"><?= __('Puntaje 112') ?></th>
                <th scope="col"><?= __('Observacion Prueba') ?></th>
                <th scope="col"><?= __('Observacion General Lapso') ?></th>
                <th scope="col"><?= __('Registro Eliminado') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($lapso->prueba_lapsos as $pruebaLapsos): ?>
            <tr>
                <td><?= h($pruebaLapsos->id) ?></td>
                <td><?= h($pruebaLapsos->lapso_id) ?></td>
                <td><?= h($pruebaLapsos->materia_id) ?></td>
                <td><?= h($pruebaLapsos->student_id) ?></td>
                <td><?= h($pruebaLapsos->puntaje) ?></td>
                <td><?= h($pruebaLapsos->puntaje_112) ?></td>
                <td><?= h($pruebaLapsos->observacion_prueba) ?></td>
                <td><?= h($pruebaLapsos->observacion_general_lapso) ?></td>
                <td><?= h($pruebaLapsos->registro_eliminado) ?></td>
                <td><?= h($pruebaLapsos->created) ?></td>
                <td><?= h($pruebaLapsos->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PruebaLapsos', 'action' => 'view', $pruebaLapsos->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PruebaLapsos', 'action' => 'edit', $pruebaLapsos->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PruebaLapsos', 'action' => 'delete', $pruebaLapsos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pruebaLapsos->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
