<?php
    $tipoOpciones =
        [
            'Rasgos de personalidad' => 'Rasgos de personalidad'
        ];
?>
<div class="container">
    <div class="page-header">
	    <h3>Agregar opción de usuario</h3>
	</div>
    <?= $this->Form->create($opcionesUsuario) ?>
        <fieldset>
            <input type='hidden' name='user_id' value=<?= $current_user['id'] ?>>
            <div class="row">
                <div class="col-md-4">
                    <?php
                        echo $this->Form->input('lapso_id', ['label' => 'Lapso: *', 'options' => $lapsos, 'required']);
                        echo $this->Form->input('materia_id', ['label' => 'Materia: *', 'options' => $materias, 'required']);
                        echo $this->Form->input('tipo_opcion', ['label' => 'Tipo de opción: *', 'options' => $tipoOpciones, 'required']);
                        echo $this->Form->input('descripcion_opcion', ['label' => 'Opción: *', 'required']);
                    ?>
                </div>
            </div>  
        </fieldset>
        <?= $this->Form->button(__('Registrar')) ?>
    <?= $this->Form->end() ?>
<br />
<br />
</div>