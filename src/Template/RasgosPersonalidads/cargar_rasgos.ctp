<?php
    $literalRasgo =
        [
            'A' => 'A',
            'B' => 'B',
            'C' => 'C'
        ];
?>
<div class="container">
    <div class="page-header">
        <h3>Rasgos del estudiante</h3>
    </div>
</div>
<?= $this->Form->create() ?>
    <fieldset>
        <?php foreach ($rasgosPersonalidad as $rasgo): ?>
            <div class="row">
                <div class="col-md-3">
                    <?= $this->Form->input('rasgo_' . $rasgo->id, ['label' => $rasgo->opciones_usuario->descripcion_opcion, 'options' => $literalRasgo, 'value' => $rasgo->calificacion]); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </fieldset>
    <?= $this->Form->button(__('Registrar')) ?>
    <?= $this->Form->end() ?>
</div>