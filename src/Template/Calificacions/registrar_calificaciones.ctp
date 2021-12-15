<?php
    use Cake\Routing\Router; 
    $notasBachiller = 
    [
        null => '',
        '0' => '0',
        '1' => '1',
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
        '16' => '16',
        '17' => '17',
        '18' => '18',
        '19' => '19',
        '20' => '20',
    ];
?>
<div class="row">
    <div class="col-md-12">
		<div class="page-header">
            <?= $this->Html->link('Lista de calificaciones descriptivas de lapso', ['action' => 'index'], ['class' => 'btn btn-sm btn-default']); ?>
	        <h3>Calificaciones del estudiante</h3>
            <h4>Estudiante: <?= $estudiante->full_name ?></h4>
            <h4>Materia: <?= $materia->full_name ?></h4>
            <h4>Lapso: <?= $lapso->numero_lapso ?></h4>
        </div>
    </div>
</div>
<?= $this->Form->create() ?>
    <fieldset>
        <input type='hidden' name='id_estudiante' value=<?= $idEstudiante ?>>
        <input type='hidden' name='id_materia' value=<?= $idMateria ?>>
        <input type='hidden' name='id_lapso' value=<?= $idLapso ?>>
        <?php foreach ($calificaciones as $calificacion): ?>
            <div class="row">
                <div class="col-md-3">
                    <?= $this->Form->input('nota_' . $calificacion->id, ['label' => 'Calificación - ' . $calificacion->objetivo->objetivo, 'id' => 'nota-' . $calificacion->id, 'options' => $notasBachiller, 'value' => $calificacion->puntaje]); ?>
                </div>
                <div class="col-md-2">
                    <?= $this->Form->input('nota112_' . $calificacion->id, ['label' => 'Art. 112', 'id' => 'nota-' . $calificacion->id, 'options' => $notasBachiller, 'value' => $calificacion->puntaje_112]); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </fieldset>
    <div class="row">
        <div class="col-md-2">
            <?= $this->Form->button(__('Registrar')) ?>
        </div>
    </div>
<?= $this->Form->end() ?>
<br />
<br />
<script>
    $(document).ready(function() 
    {

    });    
</script>