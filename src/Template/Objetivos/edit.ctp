<?php
use Cake\I18n\Time;
	
	setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
	date_default_timezone_set('America/Caracas');
	
	$fechaActual = time::now();
?>
<div class="row">
    <div class="col-md-4">
		<div class="page-header">
	        <h3>Modificar Objetivo</h3>
	    </div>
        <?= $this->Form->create($objetivo) ?>
        <fieldset>
            <?php
                echo $this->Form->input('lapso_id', ['label' => 'Lapso: *', 'options' => $lapsos]);
                echo $this->Form->input('materia_id', ['label' => 'Materia: *', 'options' => $materias]);
                if ($idProfesor == 0):
                    echo $this->Form->input('profesor_id', ['label' => 'Profesor: *', 'options' => $profesors]);
                else:
                    echo $this->Form->input('profesor_id', ['type' => 'hidden', 'value' => $idProfesor]);
                endif;
                echo $this->Form->input('objetivo', ['label' => 'Objetivo: *', 
                    'options' => 
                        ['1' => '1', 
                        '2' => '2', 
                        '3' => '3', 
                        '4' => '4', 
                        '5' => '5',
                        '6' => '6',
                        '7' => '7',
                        '8' => '8',
                        '9' => '9',
                        '10' => '10',
                        '11' => '11',
                        '12' => '12',
                        '13' => '13',
                        '14' => '14',
                        '15' => '15',
                        'Prueba de lapso' => 'Prueba de lapso']]);
                echo $this->Form->input('fecha_objetivo', 
                    ['type' => 'date',
                    'monthNames' =>
                    ['01' => 'Enero',
                    '02' => 'Febrero',
                    '03' => 'Marzo',
                    '04' => 'Abril',
                    '05' => 'Mayo',
                    '06' => 'Junio',
                    '07' => 'Julio',
                    '08' => 'Agosto',
                    '09' => 'Septiembre',
                    '10' => 'Octubre',
                    '11' => 'Noviembre',
                    '12' => 'Diciembre'],
                    'templates' => 
                        ['dateWidget' => 
                            '<ul class="list-inline">
                                <li class="day">Día{{day}}</li>
                                <li class="month">Mes{{month}}</li>
                                <li class="year">Año{{year}}</li>
                            </ul>']]);
                echo $this->Form->input('descripcion_objetivo', ['label' => 'Descripción del objetivo: *', 'required']);
                echo $this->Form->input('instrumento_objetivo', ['label' => 'Instrumento *:', 'required']);
                echo $this->Form->input('ponderacion_objetivo', ['label' => 'Ponderación (%): *', 'required']);
                echo $this->Form->input('comentario_objetivo', ['label' => 'Observacion:']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Registrar')) ?>
        <?= $this->Form->end() ?>
        <br />
        <br />
        <br />
    </div>
</div>