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
                        <th scope="col">Nro.</th>
                        <th scope="col">Estudiante</th>
                        <th scope="col">Cédula</th>

                        <?php if ($current_user['role']  == 'Profesor aula'): ?>
                            <th scope="col">Calif. Desc. Mat.</th>
                            <th scope="col">Aprec. Lit. Mat.</th>
                            <th scope="col">Calif. Desc. Lapso</th>
                            <th scope="col">Aprec. Lit. Lapso</th>
                        <?php elseif ($current_user['role']  == 'Profesor guía'): ?>
                            <th scope="col">Calif. Desc. Mat.</th>
                        <?php elseif ($current_user['role']  == 'Profesor complementario'): ?>
                            <th scope="col">Calif. Desc.</th>
                            <th scope="col">Aprec. Calif. Num.</th>
                        <?php elseif ($current_user['role']  == 'Profesor'): ?>
                            <th scope="col">Calif. Desc. Mat.</th>
                        <?php endif; ?>

                        <?php if ($current_user['role']  == 'Profesor' || $current_user['role']  == 'Profesor guía'): ?>
                            <th scope="col">N1</th>
                            <th scope="col">N112</th>
                            <th scope="col">N2</th>
                            <th scope="col">N112</th>
                            <th scope="col">N3</th>
                            <th scope="col">N112</th>
                            <th scope="col">N4</th>
                            <th scope="col">N112</th>
                            <th scope="col">N5</th>
                            <th scope="col">N112</th>
                            <th scope="col">NPon</th>
                            <th scope="col"><span title=''>R</span></th>
                            <th scope="col"><span title=''>A</span></th>
                            <th scope="col"><span title=''>S</span></th>
                            <th scope="col">AJ</th>
                            <th scope="col">NAJ</th>
                            <th scope="col">N70%</th>
                            <th scope="col">NFL</th>
                            <th scope="col">N112</th>
                            <th scope="col">N30%</th>
                            <th scope="col">70+30%</th>
                            <th scope="col">Prob</th>
                            <th scope="col">Def</th>
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
                        $div1 = 0;
                        $div2 = 0;
                        $div3 = 0;
                        $div4 = 0;
                        $div5 = 0;
                        $divisorNotas = 1;
                        $nPon = 0;
                        if ($opcionesUsuario->count() > 0):
                            foreach ($opcionesUsuario as $opcion):
                                '$ras' . $opcion->id = '*';
                            endforeach;    
                        endif;
                        $aj = 0;
                        $nAj = 0;
                        $n70 = 0;
                        $nFL = 0;
                        $n112FL = 0;
                        $n30 = 0;
                        $n70mas30Def = 0;
                        $prob = 0;
                        $def = 0;
                        
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

                        if ($rasgosPersonalidad->count() > 0):
                            $contadorA = 0;
                            $contadorB = 0;
                            $contadorC = 0;
                            foreach ($rasgosPersonalidad as $rasgo):
                                if ($rasgo->student_id == $estudiante->id):
                                    '$ras' . $rasgo->id = $rasgo->calificacion;
                                    if ($rasgo->calificacion == 'A'):
                                        $contadorA++;
                                    elseif ($rasgo->calificacion == 'B'):
                                        $contadorB++;
                                    else:
                                        $contadorC++;
                                    endif;
                                endif;
                            endforeach;
                            if ($rasgosEstudiante != ''):
                                if ($contadorA > 1):
                                    $aj = 2;
                                elseif ($contadorB > 1):
                                    $aj = 1;
                                endif;
                            endif;
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

                        if ($notaObjetivo3 == 0 && $nota112Objetivo3 == 0): 
                            $divisorNotas = 2;
                        elseif ($notaObjetivo4 == 0 && $nota112Objetivo4 == 0): 
                            $divisorNotas = 3;
                        elseif ($notaObjetivo5 == 0 && $nota112Objetivo5 == 0): 
                            $divisorNotas = 4;
                        endif;

                        $nPon = round(($div1 + $div2 + $div3 + $div4 + $div5)/$divisorNotas, 2);

                        $nAj = round($nPon + $aj);

                        $n70 = round($nAj * 0.7);
                        $n30 = round($nFL * 0.3, 2);
                        $n70mas30Def = round($n70 + $n30, 2);
                        $prob = round($n70mas30Def);
                        $def = 0; ?>

                        <tr>
                            <td><?= $contadorEstudiantes ?></td>
                            <td><spam id=<?= 'f' . $contadorEstudiantes ?>><?= $this->Html->link($estudiante->surname . ' ' . $estudiante->first_name, ['controller' => 'Calificacions', 'action' => 'registrarCalificaciones', $estudiante->id, $materiaBuscar, $lapsoBuscar])?></spam></td>
                            <td><?= $estudiante->type_of_identification . '-' . $estudiante->identity_card ?></td>

                            <?php if ($current_user['role']  == 'Profesor aula'): ?>
                                <td>
                                    <?= $this->Html->link(__('***'), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'calificacionesDescriptivas', $lapsoBuscar,  $materiaBuscar, $estudiante->id, 'Observacions', 'index']) ?>
                                    
                                </td>

                                <td>
                                    <?= $this->Html->link(__($apreciacionMateria . '/' . $literalMateria), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'apreciacionLiteral', $lapsoBuscar,  $materiaBuscar, $estudiante->id, 'Lit', 'LiteralMaterias', 'apreciacionLiteralMateria']) ?>
                                    
                                </td>

                                <td>
                                    <?= $this->Html->link(__('***'), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'calificacionesDescriptivas', $lapsoBuscar,  $materiaBuscar, $estudiante->id, 'ObservacionesLapsos', 'index']) ?>
                                    
                                </td>

                                <td>
                                    <?= $this->Html->link(__($apreciacionLapso . '/' . $literalLapso), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'apreciacionLiteral', $lapsoBuscar,  $materiaBuscar, $estudiante->id, 'Lit', 'LiteralLapsos', 'apreciacionLiteralLapso']) ?>
                                    
                                </td>

                            <?php elseif ($current_user['role']  == 'Profesor guía'): ?>
                                <td>
                                    <?= $this->Html->link(__('***'), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'calificacionesDescriptivas', $lapsoBuscar,  $materiaBuscar, $estudiante->id, 'Observacions', 'index']) ?>
                                    
                                </td>

                            <?php elseif ($current_user['role']  == 'Profesor complementario'): ?>
                                <td>
                                    <?= $this->Html->link(__('***'), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'calificacionesDescriptivas', $lapsoBuscar,  $materiaBuscar, $estudiante->id, 'Observacions', 'index']) ?>
                                    
                                </td>

                                <td>
                                    <?= $this->Html->link(__($apreciacionMateria . '/' . $literalMateria), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'apreciacionLiteral', $lapsoBuscar,  $materiaBuscar, $estudiante->id, 'Num', 'LiteralMaterias', 'apreciacionLiteralMateria']) ?>
                                    
                                </td>

                            <?php elseif ($current_user['role']  == 'Profesor'): ?>
                                <td>
                                    <?= $this->Html->link(__('***'), ['controller' => 'ParametrosCargaCalificacions', 'action' => 'calificacionesDescriptivas', $lapsoBuscar,  $materiaBuscar, $estudiante->id, 'Observacions', 'index']) ?>
                                    
                                </td>
                            <?php endif; ?>

                            <?php if ($current_user['role']  == 'Profesor' || $current_user['role']  == 'Profesor guía'): ?>
                                <td><?= number_format($notaObjetivo1, 2, ",", ".") ?></td>
                                <td><?= number_format($nota112Objetivo1, 2, ",", ".") ?></td>
                                <td><?= number_format($notaObjetivo2, 2, ",", ".") ?></td>
                                <td><?= number_format($nota112Objetivo2, 2, ",", ".") ?></td>
                                <td><?= number_format($notaObjetivo3, 2, ",", ".") ?></td>
                                <td><?= number_format($nota112Objetivo3, 2, ",", ".") ?></td>
                                <td><?= number_format($notaObjetivo4, 2, ",", ".") ?></td>
                                <td><?= number_format($nota112Objetivo4, 2, ",", ".") ?></td>
                                <td><?= number_format($notaObjetivo5, 2, ",", ".") ?></td>
                                <td><?= number_format($nota112Objetivo5, 2, ",", ".") ?></td>
                                <td><?= number_format($nPon, 2, ",", ".") ?></td>

                                <?php if ($opcionesUsuario->count() > 0): ?>
                                    <?php foreach ($opcionesUsuario as $opcion): ?>
                                        <td>
                                            <?= $this->Html->link(__('$ras' . $opcion->id), ['controller' => 'RasgosPersonalidads', 'action' => 'verificarRasgos', $lapsoBuscar,  $materiaBuscar, $estudiante->id, 'Rasgos de personalidad']) ?>
                                        </td>
                                    <?php endforeach; ?>  
                                <?php else: ?>
                                    <td>
                                        <?= $this->Html->link(__('*'), ['controller' => 'RasgosPersonalidads', 'action' => 'verificarRasgos', $lapsoBuscar,  $materiaBuscar, $estudiante->id, 'Rasgos de personalidad']) ?>
                                    </td>
                                    <td>
                                        <?= $this->Html->link(__('*'), ['controller' => 'RasgosPersonalidads', 'action' => 'cargarRasgos', $lapsoBuscar,  $materiaBuscar, $estudiante->id, 'Rasgos de personalidad']) ?>
                                    </td>
                                    <td>
                                        <?= $this->Html->link(__('*'), ['controller' => 'RasgosPersonalidads', 'action' => 'cargarRasgos', $lapsoBuscar,  $materiaBuscar, $estudiante->id, 'Rasgos de personalidad']) ?>
                                    </td>
                                <?php endif; ?>

                                <td><?= number_format($aj, 2, ",", ".") ?></td>
                                <td><?= number_format($nAj, 2, ",", ".") ?></td>
                                <td><?= number_format($n70, 2, ",", ".") ?></td>
                                <td><?= number_format($notaObjetivoFl, 2, ",", ".") ?></td>
                                <td><?= number_format($nota112ObjetivoFl, 2, ",", ".") ?></td>
                                <td><?= number_format($n30, 2, ",", ".") ?></td>
                                <td><?= number_format($prob, 2, ",", ".") ?></td>
                                <td><?= number_format($def, 2, ",", ".") ?></td>
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