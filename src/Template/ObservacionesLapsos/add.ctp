<div class="row">
    <div class="col-md-12">
		<div class="page-header">
            <?= $this->Html->link('Lista de calificaciones descriptivas de lapso', ['action' => 'index'], ['class' => 'btn btn-sm btn-default']); ?>
	        <h3>Agregar calificación descriptiva de lapso</h3>
	    </div>
    </div>
</div>
<?= $this->Form->create($observacionesLapso) ?>
    <fieldset>
        <div class="row">
            <div class="col-md-4">
                <?php echo $this->Form->input('lapso_id', ['label' => 'Lapso: *', 'options' => $lapsos, 'value' => $idLapso, 'required']);
                echo $this->Form->input('student_id', ['label' => 'Estudiante: *', 'options' => $estudiantes, 'value' => $idEstudiante, 'required']);
                echo $this->Form->input('tipo_observacion', ['label' => 'Dimensión o tipo de calificación: *', 'required']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php echo $this->Form->input('parrafo_1', ['label' => 'Párrafo 1: *', 'type' => 'textarea', 'required']);
                echo $this->Form->input('parrafo_2', ['label' => 'Párrafo 2:', 'type' => 'textarea']);
                echo $this->Form->input('parrafo_3', ['label' => 'Párrafo 3:', 'type' => 'textarea']);
                echo $this->Form->input('parrafo_4', ['label' => 'Párrafo 4:', 'type' => 'textarea']);
                echo $this->Form->input('parrafo_5', ['label' => 'Párrafo 5:', 'type' => 'textarea']); ?>
            </div>
        </div>
    </fieldset>
    <div class="row">
        <div class="col-md-2">
            <?= $this->Form->button(__('Registrar')) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
    <br />
    <br />
</div>