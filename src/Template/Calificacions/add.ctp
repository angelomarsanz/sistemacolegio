<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Lista de calificaciones'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="calificacions form large-9 medium-8 columns content">
    <?= $this->Form->create($calificacion) ?>
    <fieldset>
        <legend><?= __('Agregar nueva calificación') ?></legend>
        <?php
            echo $this->Form->input('student_id', ['label' => 'Estudiante: *', 'options' => $students]);
            echo $this->Form->input('objetivo_id', ['label' => 'Objetivo: *', 'options' => $objetivos]);
            echo $this->Form->input('puntaje', 
                ['label' => 'Puntaje: *', 
                'options' => 
                    [
                        null => '',
                        'A' => 'A',
                        'B' => 'B',
                        'C' => 'C',
                        'D' => 'D',
                        'E' => 'D',
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
                    ]
                ]);
            echo $this->Form->input('puntaje_112:', 
                ['label' => 'Puntaje 112:',
                'options' => 
                    [
                        null => '',
                        'A' => 'A',
                        'B' => 'B',
                        'C' => 'C',
                        'D' => 'D',
                        'E' => 'D',
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
                    ]
                ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Registrar')) ?>
    <?= $this->Form->end() ?>
</div>
