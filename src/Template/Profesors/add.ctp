<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Profesors'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="profesors form large-9 medium-8 columns content">
    <?= $this->Form->create($profesor) ?>
    <fieldset>
        <legend><?= __('Add Profesor') ?></legend>
        <?php

            echo $this->Form->input('nacionalidad', ['options' => [null => " ", 'Venezolano' =>  'Venezolano', 'Extranjero' => 'Extranjero'], 'label' => 'Nacionalidad: *', 'required']);
            echo $this->Form->input('tipo_documento_identificacion', 
                ['options' => 
                [null => " ",
                    'V' => 'Cédula venezolano',
                    'E' => 'Cédula extranjero',
                    'P' => 'Pasaporte'],
                    'label' => 'Tipo de documento de identificación: *',
                    'required']);
            echo $this->Form->input('numero_documento_identificacion', ['label' => 'Número de documento de identificación: *', 'required']);
                
            echo $this->Form->input('materias._ids', ['options' => $materias]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
