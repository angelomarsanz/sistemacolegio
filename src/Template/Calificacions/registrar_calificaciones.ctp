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
<br />
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
    </ul>
    <h4>Estudiante: <?= $estudiante->full_name ?></h4>
    <h4>Materia: <?= $materia->full_name ?></h4>
    <h4>Lapso: <?= $lapso->numero_lapso ?></h4>
    <br />
    <div class="calificacions form large-9 medium-8 columns content">
        <?= $this->Form->create() ?>
            <fieldset>
                <legend><?= __('Registrar calificaciones') ?></legend>
                <input type='hidden' name='id_estudiante' value=<?= $idEstudiante ?>>
                <input type='hidden' name='id_materia' value=<?= $idMateria ?>>
                <input type='hidden' name='id_lapso' value=<?= $idLapso ?>>
                <table cellpadding="0" cellspacing="0">
                    <tbody>
                        <?php foreach ($calificaciones as $calificacion): ?>
                            <td><?= $this->Form->input('nota_' . $calificacion->id, ['label' => 'N-' . $calificacion->objetivo->objetivo, 'id' => 'nota-' . $calificacion->id, 'options' => $notasBachiller, 'value' => $calificacion->puntaje]); ?></td>
                            <td>&nbsp;&nbsp;&nbsp;</td>
                            <td><?= $this->Form->input('nota112_' . $calificacion->id, ['label' => 'N-' . $calificacion->objetivo->objetivo . ' 112', 'id' => 'nota-' . $calificacion->id, 'options' => $notasBachiller, 'value' => $calificacion->puntaje_112]); ?></td>
                            <td>&nbsp;&nbsp;&nbsp;</td>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </fieldset>
            <?= $this->Form->button(__('Registrar')) ?>
        <?= $this->Form->end() ?>
    </div>
</nav>
<script>
    $(document).ready(function() 
    {

    });    
</script>