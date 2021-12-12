<br />
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Lista de calificaciones descriptiva de lapso'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="observacionesLapsos form large-9 medium-8 columns content">
    <?= $this->Form->create($observacionesLapso) ?>
    <fieldset>
        <legend><?= __('Modificar calificación descriptiva de lapso') ?></legend>
        <?php
            echo $this->Form->input('lapso_id', ['options' => $lapsos, 'value' => $idLapso]);
            echo $this->Form->input('student_id', ['options' => $estudiantes, 'value' => $idEstudiante]);
            echo $this->Form->input('tipo_observacion', ['options' => ['Conocimiento' => 'Conocimiento', 'Convivencia' => 'Convivencia', 'Desempeño' => 'Desempeño', 'Otros' => 'Otros']]);
            echo $this->Form->input('parrafo_1', ['label' => 'Párrafo 1', 'type' => 'textarea']);
            echo $this->Form->input('parrafo_2', ['label' => 'Párrafo 2', 'type' => 'textarea']);
            echo $this->Form->input('parrafo_3', ['label' => 'Párrafo 3', 'type' => 'textarea']);
            echo $this->Form->input('parrafo_4', ['label' => 'Párrafo 4', 'type' => 'textarea']);
            echo $this->Form->input('parrafo_5', ['label' => 'Párrafo 5', 'type' => 'textarea']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Registrar')) ?>
    <?= $this->Form->end() ?>
</div>