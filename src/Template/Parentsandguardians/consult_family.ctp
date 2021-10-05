<?php
    use Cake\Routing\Router; 
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h2>Consultar datos de familias</h2>
            <p>La consulta se puede hacer por los apellidos que identifican la familia, el apellido de la madre o el apellido del representante, nombre o razón social (factura) como usted prefiera...</p>
        </div>
        <div class="row panel panel-default">
            <div class="col-md-12">
                <br />
                <label for="guardian">Escriba el primer apellido del representante</label>
                <br />
                <input type="text" class="form-control" id="guardian">
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
        $('#family').val(" ");
        $('#mother').val(" ");
        $('#guardian').val(" ");
        $("#response-container").html("");
    }
    
// Funciones Jquery

    var family = "";

    $(document).ready(function() 
    {

        $('#guardian').autocomplete(
        {
            source:'<?php echo Router::url(array("controller" => "Parentsandguardians", "action" => "busquedaApellidoRepresentante")); ?>',
            minLength: 3,
            select: function( event, ui ) {
                log("<tr id=fa" + ui.item.id + " class='family'><td>" + ui.item.value + "</td></tr>");
              }
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
                       
            $.redirect('../parentsandguardians/viewData', {idFamily : idFamily, family: family}); 

        });

// Final funciones Jquery
    });    

</script>