<?php
    use Cake\Routing\Router; 
?>
<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h3>Calificaciones</h3>
        </div>
    </div>
</div>
<div class="row">
    <?= $this->Form->create(null, ['url' => ['controller' => 'ParametrosCargaCalificacions', 'action' => 'postParametrosCargaCalificaciones']]) ?>
        <fieldset>
            <input type='hidden' name='id_estudiante' value='1'>
            <div class="col-md-1">
                <?php
                    echo $this->Form->input('id_lapso', ['id' => 'lapsos', 'label' => 'Lapso', 'options' => $lapsos, 'value' => $lapsoBuscar]);
                ?>
            </div>
            <div class="col-md-9">
                <?php
                    echo $this->Form->input('id_materia', ['type' => 'select', 'id' => 'materias', 'label' => 'Materia', 'options' => $materias, 'value' => $materiaBuscar]);
                ?>
            </div>
        </fieldset>
        <div class="col-md-2">
                <?= $this->Form->button(__('Filtrar')) ?>
        </div>
    <?= $this->Form->end() ?>
</div>
<div class="row">
    <div class="col-md-12">
        <?php $contadorEstudiantes = 1 ?>
        <div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nro.&nbsp;&nbsp;&nbsp;</th>
                        <th scope="col">Estudiante&nbsp;&nbsp;&nbsp;</th>
                        <th scope="col">Cédula&nbsp;&nbsp;&nbsp;</th>

                        <?php if ($current_user['role']  == 'Profesor aula' || $current_user['role']  == 'Profesor guía'): ?>
                            <th scope="col">Calif. Desc. Mat.&nbsp;&nbsp;&nbsp;</th>
                            <th scope="col">Aprec. Lit. Mat.&nbsp;&nbsp;&nbsp;</th>
                            <th scope="col">Calif. Desc. Lapso&nbsp;&nbsp;&nbsp;</th>
                            <th scope="col">Aprec. Lit. Lapso&nbsp;&nbsp;&nbsp;</th>
                        <?php elseif ($current_user['role']  == 'Profesor complementario'): ?>
                            <th scope="col">Calif. Desc.&nbsp;&nbsp;&nbsp;</th>
                            <th scope="col">Aprec. Calif. Num.&nbsp;&nbsp;&nbsp;</th>
                        <?php elseif ($current_user['role']  == 'Profesor'): ?>
                            <th scope="col">Calif. Desc. Mat.&nbsp;&nbsp;&nbsp;</th>
                        <?php endif; ?>

                        <?php if ($current_user['role']  == 'Profesor' || $current_user['role']  == 'Profesor guía'): ?>
                            <th scope="col">N1&nbsp;&nbsp;&nbsp;</th>
                            <th scope="col">N112&nbsp;&nbsp;&nbsp;</th>
                            <th scope="col">N2&nbsp;&nbsp;&nbsp;</th>
                            <th scope="col">N112&nbsp;&nbsp;&nbsp;</th>
                            <th scope="col">N3&nbsp;&nbsp;&nbsp;</th>
                            <th scope="col">N112&nbsp;&nbsp;&nbsp;</th>
                            <th scope="col">N4&nbsp;&nbsp;&nbsp;</th>
                            <th scope="col">N112&nbsp;&nbsp;&nbsp;</th>
                            <th scope="col">N5&nbsp;&nbsp;&nbsp;</th>
                            <th scope="col">N112&nbsp;&nbsp;&nbsp;</th>
                            <th scope="col">NAJ&nbsp;&nbsp;&nbsp;</th>
                            <th scope="col">N70%&nbsp;&nbsp;&nbsp;</th>
                            <th scope="col">NFL&nbsp;&nbsp;&nbsp;</th>
                            <th scope="col">N112&nbsp;&nbsp;&nbsp;</th>
                            <th scope="col">N30%&nbsp;&nbsp;&nbsp;</th>
                            <th scope="col">NDEF&nbsp;&nbsp;&nbsp;</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estudiantes as $estudiante):
                        $notaObjetivo1 = 0; 
                        $nota112Objetivo1 = 0;
                        $notaObjetivo2 = 0;
                        $nota112Objetivo2 = 0;
                        $notaObjetivo3 = 0;
                        $nota112Objetivo3 = 0;
                        $notaObjetivo4 = 0;
                        $nota112Objetivo4 = 0;
                        $notaObjetivo5 = 0;
                        $nota112Objetivo5 = 0;
                        $notaObjetivoFl = 0;
                        $nota112ObjetivoFl = 0; 
                        $nAj = 0;
                        $n70 = 0;
                        $nFL = 0;
                        $n30 = 0;
                        $nDef = 0;
                        $div1 = 0;
                        $div2 = 0;
                        $div3 = 0;
                        $div4 = 0;
                        $div5 = 0;
                        $divisorNotas = 0;
                        $apreciacionMateria = '***';
                        $literalMateria = '***';
                        $calificacionNumericaMateria = '***';
                        $apreciacionLapso = '***';
                        $literalLapso = '***';

                        if ($literalesMateria->count() > 0):
                            foreach ($literalesMateria as $literalMat):
                                if ($literalMat->student_id == $estudiante->id):
                                    $apreciacionMateria = $literalMat->calificacion_descriptiva;
                                    $literalMateria = $literalMat->literal;
                                    $calificacionNumericaMateria = $literalMat->numero;
                                endif;
                            endforeach;
                        endif;

                        if ($literalesLapso->count() > 0):
                            foreach ($literalesLapso as $literalLap):
                                if ($literalLap->student_id == $estudiante->id):
                                    $apreciacionLapso = $literalLap->calificacion_descriptiva;
                                    $literalLapso = $literalLap->literal;
                                endif;
                            endforeach;
                        endif;
                        
                        if ($calificaciones->count() > 0):
                            foreach ($calificaciones as $calificacion): 
                                if ($calificacion->student_id == $estudiante->id):
                                    switch ($calificacion->objetivo->objetivo) 
                                    {
                                        case '1':
                                            $notaObjetivo1 = $calificacion->puntaje;
                                            $nota112Objetivo1 = $calificacion->puntaje_112;
                                            break;
                                        case '2':
                                            $notaObjetivo2 = $calificacion->puntaje;
                                            $nota112Objetivo2 = $calificacion->puntaje_112;
                                            break;
                                        case '3':
                                            $notaObjetivo3 = $calificacion->puntaje;
                                            $nota112Objetivo3 = $calificacion->puntaje_112;
                                            break;
                                        case '4':
                                            $notaObjetivo4 = $calificacion->puntaje;
                                            $nota112Objetivo4 = $calificacion->puntaje_112;
                                            break;
                                        case '5':
                                            $notaObjetivo5 = $calificacion->puntaje;
                                            $nota112Objetivo5 = $calificacion->puntaje_112;
                                            break;
                                        case 'Prueba de lapso':
                                            $notaObjetivoFl = $calificacion->puntaje;
                                            $nota112ObjetivoFl = $calificacion->puntaje_112;
                                            break;
                                    }
                                endif;
                            endforeach; 
                        endif;
                            
                        $nota112Objetivo1 > 0 ? $div1 = $nota112Objetivo1 : $div1 = $notaObjetivo1;
                        $nota112Objetivo2 > 0 ? $div2 = $nota112Objetivo2 : $div2 = $notaObjetivo2;
                        $nota112Objetivo3 > 0 ? $div3 = $nota112Objetivo3 : $div3 = $notaObjetivo3; 
                        $nota112Objetivo4 > 0 ? $div4 = $nota112Objetivo4 : $div4 = $notaObjetivo4; 
                        $nota112Objetivo5 > 0 ? $div5 = $nota112Objetivo5 : $div5 = $notaObjetivo5;
                        $nota112ObjetivoFl > 0 ? $nFL = $nota112ObjetivoFl : $nFL = $notaObjetivoFl;  

                        if ($notaObjetivo5 > 0 || $nota112Objetivo5 > 0):                  
                            $divisorNotas = 5;
                        else:
                            $divisorNotas = 4;
                        endif;

                        $nAj = round(($div1 + $div2 + $div3 + $div4 + $div5)/$divisorNotas);

                        $n70 = round($nAj * 0.7, 2);
                        $n30 = round($nFL * 0.3, 2);
                        $nDef = round($n70 + $n30); ?>

                        <tr>
                            <td><?= $contadorEstudiantes ?></td>
                            <td><spam id=<?= 'f' . $contadorEstudiantes ?>><?= $this->Html->link($estudiante->surname . ' ' . $estudiante->first_name, ['controller' => 'Calificacions', 'action' => 'registrarCalificaciones', $estudiante->id, $materiaBuscar, $lapsoBuscar])?></spam>&nbsp;&nbsp;&nbsp;</td>
                            <td><?= $estudiante->type_of_identification . '-' . $estudiante->identity_card ?>&nbsp;&nbsp;&nbsp;</td>

                            <?php if ($current_user['role']  == 'Profesor aula' || $current_user['role']  == 'Profesor guía'): ?>
                                <td>
                                    <?= $this->Html->link(__('***'), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'calificacionesDescriptivas', $lapsoBuscar,  $materiaBuscar, $estudiante->id, 'Observacions', 'index']) ?>
                                    &nbsp;&nbsp;&nbsp;
                                </td>

                                <td>
                                    <?= $this->Html->link(__($apreciacionMateria . '/' . $literalMateria), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'apreciacionLiteral', $lapsoBuscar,  $materiaBuscar, $estudiante->id, 'Lit', 'LiteralMaterias', 'apreciacionLiteralMateria']) ?>
                                    &nbsp;&nbsp;&nbsp;
                                </td>

                                <td>
                                    <?= $this->Html->link(__('***'), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'calificacionesDescriptivas', $lapsoBuscar,  $materiaBuscar, $estudiante->id, 'ObservacionesLapsos', 'index']) ?>
                                    &nbsp;&nbsp;&nbsp;
                                </td>

                                <td>
                                    <?= $this->Html->link(__($apreciacionLapso . '/' . $literalLapso), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'apreciacionLiteral', $lapsoBuscar,  $materiaBuscar, $estudiante->id, 'Lit', 'LiteralLapsos', 'apreciacionLiteralLapso']) ?>
                                    &nbsp;&nbsp;&nbsp;
                                </td>

                            <?php elseif ($current_user['role']  == 'Profesor complementario'): ?>
                                <td>
                                    <?= $this->Html->link(__('***'), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'calificacionesDescriptivas', $lapsoBuscar,  $materiaBuscar, $estudiante->id, 'Observacions', 'index']) ?>
                                    &nbsp;&nbsp;&nbsp;
                                </td>

                                <td>
                                    <?= $this->Html->link(__($apreciacionMateria . '/' . $literalMateria), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'apreciacionLiteral', $lapsoBuscar,  $materiaBuscar, $estudiante->id, 'Num', 'LiteralMaterias', 'apreciacionLiteralMateria']) ?>
                                    &nbsp;&nbsp;&nbsp;
                                </td>

                            <?php elseif ($current_user['role']  == 'Profesor'): ?>
                                <td>
                                    <?= $this->Html->link(__('***'), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'calificacionesDescriptivas', $lapsoBuscar,  $materiaBuscar, $estudiante->id, 'Observacions', 'index']) ?>
                                    &nbsp;&nbsp;&nbsp;
                                </td>
                            <?php endif; ?>

                            <?php if ($current_user['role']  == 'Profesor' || $current_user['role']  == 'Profesor guía'): ?>
                                <td><?= $notaObjetivo1 ?></td>
                                <td><?= $nota112Objetivo1 ?></td>
                                <td><?= $notaObjetivo2 ?></td>
                                <td><?= $nota112Objetivo2 ?></td>
                                <td><?= $notaObjetivo3 ?></td>
                                <td><?= $nota112Objetivo3 ?></td>
                                <td><?= $notaObjetivo4 ?></td>
                                <td><?= $nota112Objetivo4 ?></td>
                                <td><?= $notaObjetivo5 ?></td>
                                <td><?= $nota112Objetivo5 ?></td>

                                <td><?= $nAj ?></td>
                                <td><?= $n70 ?></td>
                                <td><?= $notaObjetivoFl ?></td>
                                <td><?= $nota112ObjetivoFl ?></td>
                                <td><?= $n30 ?></td>
                                <td><?= $nDef ?></td>
                            <?php endif; ?>

                        </tr>
                        <?php $contadorEstudiantes++ ?> 
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('Siguiente') . ' >') ?>
            </ul>
            <p><?= $this->Paginator->counter() ?></p>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() 
    {

    });    
</script>