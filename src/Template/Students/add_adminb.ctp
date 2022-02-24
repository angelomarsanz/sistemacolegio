<?php
    use Cake\I18n\Time;
    use Cake\Routing\Router; 
?>
<style>
    .noverScreen
    {
		display:none;
    }
	.fontColor
	{
		color: #ff8080;
	}
</style>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h3>Registrar datos del nuevo alumno</h3>
        </div>
        <?= $this->Form->create($student, ['type' => 'file']) ?>
            <fieldset>
                <div class="row panel panel-default">
                    <div class="col-md-12">
                        <br />
                        <?php
                        echo $this->Form->input('type_of_identification', 
                        ['options' => 
                        [null => ' ',
                        'CE' => 'Cédula escolar',
                        'V' => 'Cédula venezolano',
                        'E' => 'Cédula extranjero',
                        'P' => 'Pasaporte'],
                        'label' => 'Tipo de documento de identificación: *',
                        'required' => true]);
                        echo $this->Form->input('identity_card', ['label' => 'Número de cédula o pasaporte: *', 'type' => 'number', 'required' => true]);
                        echo $this->Form->input('surname', ['label' => 'Primer apellido: *', 'required' => true]);
                        echo $this->Form->input('first_name', ['label' => 'Primer nombre: *', 'required' => true]);
                        echo $this->Form->input('number_of_brothers', ['label' => 'Tipo (Alumno nuevo): *', 'required' => true, 'options' => 
                            [null => " ",
                            0 => 'Alumno nuevo '.$anoInscripcion.'-'.$anoInscripcionMasUno,
                            1 => 'Alumno nuevo '.$anoInscripcionMasUno.'-'.$anoInscripcionMasDos]]);                        
                        
                        echo $this->Form->input('level_of_study', 
                            [
                                'options' => 
                                    [
                                        null => " ",
                                        'Pre-escolar, pre-kinder' => 'Pre-escolar, pre-kinder',                                
                                        'Pre-escolar, kinder' => 'Pre-escolar, kinder',
                                        'Pre-escolar, preparatorio' => 'Pre-escolar, preparatorio',
                                        'Primaria, 1er. grado' => 'Primaria, 1er. grado',
                                        'Primaria, 2do. grado' => 'Primaria, 2do. grado',
                                        'Primaria, 3er. grado' => 'Primaria, 3er. grado',
                                        'Primaria, 4to. grado' => 'Primaria, 4to. grado', 
                                        'Primaria, 5to. grado' => 'Primaria, 5to. grado', 
                                        'Primaria, 6to. grado' => 'Primaria, 6to. grado',
                                        'Secundaria, 1er. año' => 'Secundaria, 1er. año',
                                        'Secundaria, 2do. año' => 'Secundaria, 2do. año',
                                        'Secundaria, 3er. año' => 'Secundaria, 3er. año',
                                        'Secundaria, 4to. año' => 'Secundaria, 4to. año',
                                        'Secundaria, 5to. año' => 'Secundaria, 5to. año'
                                    ],
                                'label' => 'Nivel de estudio que cursará el alumno en el próximo año escolar: *',
                                'required' => true
                            ]);

                        echo $this->Form->input('tipo_descuento', ['label' => 'Tipo de descuento:', 'options' => 
                        [null => "Sin descuento",
                        'Empleado' => 'Empleado',
                        'Especial' => 'Especial',
                        'Hijos' => 'Hijos',]]);
                        echo $this->Form->input('discount', ['label' => 'Porcentaje de descuento', 'type', 'number']);
                    ?>
            </fieldset>
        <?= $this->Form->button(__('Guardar'), ['class' =>'btn btn-success', 'id' => 'save-student']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<script>
    $(document).ready(function() 
    {
        $('#number-of-brothers-x').change(function(e) 
        {
			e.preventDefault();
		
			$.post('<?php echo Router::url(["controller" => "Students", "action" => "sameNames"]); ?>', {'surname' : $("#surname").val(), 'firstName' : $("#first-name").val()}, null, "json")				
                     
            .done(function(response) 
            {
                if (response.success) 
                {              
					$('#same-names').removeClass('noverScreen');
					
					students = '';
					accountArray = 0;
					
                    $.each(response.data.students, function(key, value) 
                    {					
                        $.each(value, function(studentKey, studentValue) 
                        {					
							if (studentKey == 'student')
							{
								if (accountArray == 0)
								{
									students = '<tr><td>' + studentValue + '</td>';
								}
								else
								{
									students += '<tr><td>' + studentValue + '</td>';
								}
								accountArray++;
							}
							else if (studentKey == 'family')
							{
								students +=  '<td>' + studentValue + '</td>';
								familyStudent = studentValue;
							}
							else
							{
								students += '<td><a href=<?= Router::url(array("controller" => "Students", "action" => "viewConsult")) ?>/' + studentValue + '<?= '/'. $idParentsandguardians ?>/familia/Students/registerNewStudents>Ver</a></td></tr>';
							}
						});
                    });
                    $('#tbody-same-names').html(students);
                } 
            })
            .fail(function(jqXHR, textStatus, errorThrown) 
            {
                $("#tbody-same-names").html("Algo ha fallado: " + textStatus);
            });  
        });			
		
        $('#save-student').click(function(e) 
        {
            $('#surname').val($.trim($('#surname').val().toUpperCase()));
            $('#first-name').val($.trim($('#first-name').val().toUpperCase()));
        });
    });
</script>