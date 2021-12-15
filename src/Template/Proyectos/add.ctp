<?php
use Cake\I18n\Time;
	
	setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
	date_default_timezone_set('America/Caracas');
	
	$fechaActual = time::now();
?>
<div class="row">
    <div class="col-md-4">
		<div class="page-header">
	        <h3>Agregar proyecto</h3>
	    </div>
        <?= $this->Form->create($proyecto) ?>
        <fieldset>
            <input type='hidden' name='section_id' value=<?= $materia->section_id ?>>
            <?php
                echo $this->Form->input('lapso_id', ['label' => 'Lapso: *', 'options' => $lapsos, 'required']);
                echo $this->Form->input('identificador_proyecto', ['label' => 'Identificador del proyecto: *', 'required']);
                echo $this->Form->input('fecha_proyecto',
                    ['label' => 'Fecha del proyecto: *',
                    'type' => 'date',
                    'value' => $fechaActual,
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
                            </ul>'],
                    'required']);
                echo $this->Form->input('descripcion_proyecto', ['label' => 'Descripción del proyecto: *', 'required']);
                echo $this->Form->input('instrumento_proyecto', ['label' => 'Instrumento del proyecto: *']);
                echo $this->Form->input('ponderacion_proyecto', ['label' => 'Ponderación del proyecto: *', 'value' => 0]);
                echo $this->Form->input('comentario_proyecto', ['label' => 'Comentario del proyecto: *']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Registrar')) ?>
        <?= $this->Form->end() ?>
        <br />
        <br />
        <br />
    </div>
</div>
