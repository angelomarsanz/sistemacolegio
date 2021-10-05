<?php
    use Cake\Routing\Router; 
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h2>Registro básico de nuevos alumnos</h2>
        </div>
        <p>Si el nuevo estudiante es hijo de un representante que no está registrado en el sistema, por favor agregue los datos del nuevo representante:</p>
        <?= $this->Html->link('Agregar nuevo representante', ['controller' => 'Parentsandguardians', 'action' => 'addb'], ['class' => 'btn btn-success']); ?>
        <br />
        <br />
        <p>Si el nuevo estudiante es miembro de un representante que ya está registrado en el sistema, por favor busque el representante:</p>
        <div class="row panel panel-default">
            <div class="col-md-12">
                <br />
                <label for="family">Escriba los apellidos del representante:</label>
                <br />
                <input type="text" class="form-control" id="family-search">
                <br />
                <p id="header-messages"></p>
                <br />
                <div class="panel panel-default pre-scrollable" style="height:220px;">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <tbody id="response-container"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// Declaración de variables
    var selectFamily = -1;
    
// Funciones

    function log(message) 
    {
        cleanPager();
        $("#response-container").html(message);
    }

    function cleanPager()
    {
        $('#family-search').val(" ");
        $("#response-container").html("");
    }
    
    function listFamilies(newFamily)
    {
        $.post('<?php echo Router::url(array("controller" => "Students", "action" => "everyFamily")); ?>', {"newFamily" : newFamily}, null, "json")
            
        .done(function(response) 
        {
            if (response.success) 
            {
                var output = " "; 
                $.each(response.data.families, function(key, value) 
                {
                    $.each(value, function(userkey, uservalue) 
                    {
                        if (userkey == 'id')
                            output += "<tr id=fa" + uservalue + " class='family'><td>";
                        else if (userkey == 'family')
                            output += uservalue + " (";
                        else if (userkey == 'surname')
                            output += uservalue + " ";
                        else
                            output += uservalue + ")</td></tr>";
                    });
                });
                $("#response-container").html(" ");
                $("#response-container").html(output);
            } 
            else 
            {
                $("#response-container").html('No ha habido suerte: ' + response.data.message);
            }
                
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
                
            $("#response-container").html("Algo ha fallado: " + textStatus);
                
        });
    }

// Funciones Jquery

    $(document).ready(function() 
    {
        $('#family-search').autocomplete(
        {
            source:'<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "busquedaApellidoRepresentante")); ?>',
            minLength: 3,
            select: function( event, ui ) {
                log("<tr id=fa" + ui.item.id + " class='family'><td>" + ui.item.value + "</td></tr>");
              }
        });

        $('#newfamily').click(function(e) 
        {
            e.preventDefault();
        
            cleanPager();
            
            $("#response-container").html("Por favor espere...");
            
            listFamilies(1);
        });

        $('#everyfamily').click(function(e) 
        {
            e.preventDefault();
        
            cleanPager();
            
            $("#response-container").html("Por favor espere...");
            
            listFamilies(0);
        });

        $("#response-container").on("click", ".family", function()
        {
            idFamily = $(this).attr('id').substring(2);
            
            if (selectFamily > -1)
            {
                $('#fa' + selectFamily).css('background-color', 'white');
            }
            
            selectFamily = idFamily;
            
            $('#fa' + selectFamily).css('background-color', '#c2c2d6');  
    
            cleanPager();
            
            $("#header-messages").html("Por favor espere...");
                       
            $.redirect('<?php echo Router::url(array("controller" => "Students", "action" => "addAdminpb")); ?>', {idFamily : idFamily}); 
        });

// Final funciones Jquery
    });    

</script>