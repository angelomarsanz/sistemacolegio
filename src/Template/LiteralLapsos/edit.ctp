<br />
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
    </ul>
</nav>
<div class="literalLapsos form large-9 medium-8 columns content">
    <?= $this->Form->create($literalLapso) ?>
    <fieldset>
        <legend><?= __('Apreciación y literal de Lapso') ?></legend>
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
            
            echo $this->Form->input('literal', ['label' => 'Literal de lapso', 'options' => 
            [
                '***' => '',
                'A' => 'A',
                'B' => 'B',
                'C' => 'C',
                'D' => 'D',
                'E' => 'E',
            ]]);
    ?>
    </fieldset>
    <?= $this->Form->button(__('Registrar')) ?>
    <?= $this->Form->end() ?>
</div>