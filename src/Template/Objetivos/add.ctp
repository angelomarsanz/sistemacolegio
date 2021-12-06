<?php
use Cake\I18n\Time;
	
	setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
	date_default_timezone_set('America/Caracas');
	
	$fechaActual = time::now();
?>
    <nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Lista de objetivos'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="objetivos form large-9 medium-8 columns content">
    <?= $this->Form->create($objetivo) ?>
    <fieldset>
        <legend><?= __('Agregar Nuevo Objetivo') ?></legend>
        <?php
            echo $this->Form->input('lapso_id', ['label' => 'Lapso: *', 'options' => $lapsos]);
            echo $this->Form->input('materia_id', ['label' => 'Materia: *', 'options' => $materias]);
            echo $this->Form->input('section_id', ['label' => 'Sección: *', 'options' => $secciones]);
            echo $this->Form->input('profesor_id', ['label' => 'Profesor: *', 'options' => $profesors]);
            echo $this->Form->input('objetivo', ['label' => 'Nro. del objetivo: *', 
                'options' => 
                    ['Objetivo 1' => 'Objetivo 1', 
                    'Objetivo 2' => 'Objetivo 2', 
                    'Objetivo 3' => 'Objetivo 3', 
                    'Objetivo 4' => 'Objetivo 4', 
                    'Objetivo 5' => 'Objetivo 5',
                    'Prueba de lapso' => 'Prueba de lapso',
                    'Literal de lapso (Primaria)' => 'Literal de lapso (Primaria)']]);
            echo $this->Form->input('fecha_objetivo', 
                ['type' => 'date',
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
                        </ul>']]);
            echo $this->Form->input('descripcion_objetivo', ['label' => 'Descripción del objetivo: *', 'required']);
            echo $this->Form->input('instrumento_objetivo', ['label' => 'Instrumento *:', 'required']);
            echo $this->Form->input('ponderacion_objetivo', ['label' => 'Ponderación: *', 'required', 
                'options' => 
                    [
                        '25' => '25% - Objetivo', 
                        '30' => '30% - Prueba de lapso',
                        '100' => '100% - Literal de lapso (Primaria)'
                    ]]);
            echo $this->Form->input('comentario_objetivo', ['label' => 'Observacion:']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Registrar')) ?>
    <?= $this->Form->end() ?>
</div>