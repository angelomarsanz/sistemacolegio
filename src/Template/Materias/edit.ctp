<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Lista de materias'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="materias form large-9 medium-8 columns content">
    <?= $this->Form->create($materia) ?>
    <fieldset>
        <legend><?= __('Modificar Materia') ?></legend>
        <?php
            echo $this->Form->input('section_id', ['label' => 'Sección: *', 'options' => $secciones]);
            echo $this->Form->input('nombre_materia', ['label' => 'Nombre: *']);
            echo $this->Form->input('descripcion_materia', ['label' => 'Descripción: *']);
            echo $this->Form->input('grado_materia', ['type' => 'hidden']);
            echo $this->Form->input('cantidad_horas_semanales', ['label' => 'Cantidad de horas semanales: *']);
            echo $this->Form->input('profesors._ids', ['label' => 'Materia(s): *', 'options' => $profesors]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Registrar'), ['id' => 'registrar-materia']) ?>
    <?= $this->Form->end() ?>
</div>
<script>
    $(document).ready(function() 
    {
        $( "#section-id" ).change(function() 
        {
            $('#grado').val($('#section-id option:selected').text());
        });
        $('#registrar-materia').click(function(e) 
        {
            $('#nombre-materia').val($('#nombre-materia').val().toUpperCase());
            $('#descripcion-materia').val($('#descripcion-materia').val().toUpperCase());
        });
    });
</script>