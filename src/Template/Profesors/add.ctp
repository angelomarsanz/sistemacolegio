<?php
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
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Profesors'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="profesors form large-9 medium-8 columns content">
    <?= $this->Form->create($profesor) ?>
    <fieldset>
        <legend><?= __('Nuevo Profesor') ?></legend>
        <?php

            echo $this->Form->input('nacionalidad', ['options' => [null => " ", 'VENEZOLANO' =>  'Venezolano', 'EXTRANJERO' => 'Extranjero'], 'label' => 'Nacionalidad: *', 'required']);
            echo $this->Form->input('tipo_documento_identificacion', 
                ['options' => 
                    [null => "",
                    'V' => 'Cédula venezolano',
                    'E' => 'Cédula extranjero',
                    'P' => 'Pasaporte'],
                    'label' => 'Tipo de documento de identificación: *',
                    'required']);
            echo $this->Form->input('numero_documento_identificacion', ['label' => 'Número de documento de identificación: *', 'required', 'type' => 'number']); ?>

            <p class='noverScreen fontColor' id='mismo-usuario'>Ya existe otro usuario con el mismo nombre</p>

            <?php
            echo $this->Form->input('primer_nombre', ['label' => 'Primer nombre: *', 'required']);
            echo $this->Form->input('segundo_nombre', ['label' => 'Segundo nombre: ']);
            echo $this->Form->input('primer_apellido', ['label' => 'Primer apellido: *', 'required']);
            echo $this->Form->input('segundo_apellido', ['label' => 'Segundo apellido: ']);

            echo $this->Form->input('sexo', ['options' => [null => " ", 'FEMENINO' =>  'Femenino', 'MASCULINO' => 'Masculino'], 'label' => 'Sexo: *', 'required']);


            echo $this->Form->input('titulo_universitario', ['label' => 'Título universitario: *', 'required']);
            echo $this->Form->input('direccion_habitacion', ['label' => 'Dirección de habitación: *', 'required']);
            echo $this->Form->input('celular', ['label' => 'Nro. De teléfono celular: *', 'type' => 'number', 'required']);
            echo $this->Form->input('telefono_fijo', ['label' => 'Nro. De teléfono fijo: *', 'type' => 'number', 'required']);
            echo $this->Form->input('correo_electronico', ['label' => 'Correo electrónico: *', 'type' => 'email', 'required']);
                
            echo $this->Form->input('materias._ids', ['options' => $materias]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Registrar'), ['id' => 'registrar-profesor']) ?>
    <?= $this->Form->end() ?>
</div>
<script>
    var tipoDocumentoIdentificacion = '';
    var numeroDocumentoIdentificacion = 0;
    var indicadorTipoDocumento = 0;
    var documentoInvalido = 0;
    $(document).ready(function() 
    {
        $('#tipo-documento-identificacion').change(function(e) 
        {
			e.preventDefault();

            tipoDocumentoIdentificacion = $("#tipo-documento-identificacion").val();

            if (numeroDocumentoIdentificacion == 0)
            {
                $("#numero-documento-identificacion").focus();
            }
            else
            {
                $.post('<?php echo Router::url(["controller" => "Users", "action" => "verificarUsuario"]); ?>', {'usuario' : $("#tipo-documento-identificacion").val() + $("#numero-documento-identificacion").val()}, null, "json")				
                        
                .done(function(response) 
                {
                    if (response.success) 
                    {        
                        documentoInvalido = 1;      
                        $('#mismo-usuario').removeClass('noverScreen');                       
                        $("#numero-documento-identificacion").focus();
                    }
                    else
                    {
                        documentoInvalido = 0;
                        if ($("#mismo-usuario").hasClass("noverScreen") == false)
                        {
                            $('#mismo-usuario').addClass('noverScreen');  
                        }
                    } 
                })
                .fail(function(jqXHR, textStatus, errorThrown) 
                {
                    $("#tbody-same-names").html("Algo ha fallado: " + textStatus);
                }); 
            }
        }); 

        $('#numero-documento-identificacion').change(function(e) 
        {
			e.preventDefault();

            numeroDocumentoIdentificacion = $("#numero-documento-identificacion").val();

            if (tipoDocumentoIdentificacion == '')
            {
                alert('Por favor indique el tipo de documento de identificación');
                $("#tipo-documento-identificacion").focus();
            }
            else
            {
                $.post('<?php echo Router::url(["controller" => "Users", "action" => "verificarUsuario"]); ?>', {'usuario' : $("#tipo-documento-identificacion").val() + $("#numero-documento-identificacion").val()}, null, "json")				
                        
                .done(function(response) 
                {
                    if (response.success) 
                    {        
                        documentoInvalido = 1;      
                        $('#mismo-usuario').removeClass('noverScreen');                       
                        $("#numero-documento-identificacion").focus();
                    }
                    else
                    {
                        documentoInvalido = 0;
                        if ($("#mismo-usuario").hasClass("noverScreen") == false)
                        {
                            $('#mismo-usuario').addClass('noverScreen');  
                        }
                    } 
                })
                .fail(function(jqXHR, textStatus, errorThrown) 
                {
                    $("#tbody-same-names").html("Algo ha fallado: " + textStatus);
                }); 
            } 
        });			

        $('#registrar-profesor').click(function(e) 
        {
            console.log('documentoInvalido ' + documentoInvalido);
            if (documentoInvalido == 1)
            {
                alert("Número de documento de identificación inválido");
                return false;
            }

            $('#primer-nombre').val($('#primer-nombre').val().toUpperCase());
            $('#segundo-nombre').val($('#segundo-nombre').val().toUpperCase());
            $('#primer-apellido').val($('#primer-apellido').val().toUpperCase());
            $('#segundo-apellido').val($('#segundo-apellido').val().toUpperCase());
            $('#titulo-universitario').val($('#titulo-universitario').val().toUpperCase());
            $('#direccion-habitacion').val($('#direccion-habitacion').val().toUpperCase());
            $('#correo-electronico').val($('#correo-electronico').val().toLowerCase());
        });
    });
</script>		