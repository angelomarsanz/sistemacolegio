<?php
    $calificacionNumerica =
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
</nav>
<div class="literalLapsos form large-9 medium-8 columns content">
    <?= $this->Form->create($literalMateria) ?>
    <fieldset>
        <?php if ($tipo == 'Lit'): ?>
            <legend><?= __('Apreciación y literal de Materia') ?></legend>
        <?php else: ?>
            <legend><?= __('Apreciación y calificación numérica de Materia') ?></legend>
        <?php endif; ?>
        <?php
            echo $this->Form->input('calificacion_descriptiva', ['label' => 'Apreciacion', 'options' => 
                [
                    '***'     => '',
                    'Exc'   => 'Excelente',
                    'M.B'   => 'Muy bien',
                    'B'     => 'Bien',
                    'R'     => 'Regular',
                    'M'     => 'Mejorable'
                ]]);
                if ($tipo == 'Lit'):
                    echo $this->Form->input('literal', ['label' => 'Literal de materia', 'options' => 
                    [
                        '***' => '',
                        'A' => 'A',
                        'B' => 'B',
                        'C' => 'C',
                        'D' => 'D',
                        'E' => 'E',
                    ]]);
                else:
                    echo $this->Form->input('literal', ['label' => 'Calificación númerica de materia', 'options' => $calificacionNumerica]);
                endif;
        ?>
    </fieldset>
    <?= $this->Form->button(__('Registrar')) ?>
    <?= $this->Form->end() ?>
</div>