<style>
@media screen
{
    .volver 
    {
        display:scroll;
        position:fixed;
        top: 15%;
        left: 50px;
        opacity: 0.5;
    }
    .cerrar 
    {
        display:scroll;
        position:fixed;
        top: 15%;
        left: 95px;
        opacity: 0.5;
    }
    .menumenos
    {
        display:scroll;
        position:fixed;
        bottom: 5%;
        right: 1%;
        opacity: 0.5;
        text-align: right;
    }
    .menumas 
    {
        display:scroll;
        position:fixed;
        bottom: 5%;
        right: 1%;
        opacity: 0.5;
        text-align: right;
    }
    .noverScreen
    {
      display:none
    }
}
@media print 
{
    .nover 
    {
      display:none
    }
    .saltopagina
    {
        display:block; 
        page-break-before:always;
    }
}
</style>
<div>
    <h2 style="text-align: center;">Fundación Unidad Educativa Colegio Verdad y Libertad</h1>
    <h3 style="text-align: center;">Alumnos Inscritos Desde Septiembre</h2>
    <table id="general" class="table">
        <thead>
            <tr>
                <th scope="col">Nro.</th>		
                <th scope="col">Cédula</th>	
                <th scope="col">Apellido</th>					
                <th scope="col">Nombre</th>
                <th scope="col">Grado</th>
                <th scope="col">Tipo de descuento</th>
                <th scope="col">descuento</th>
                <th scope="col">Nro. Factura</th>	
                <th scope="col">Transaccion</th>
                <th scope="col">Monto $</th>				
            </tr>
        </thead>
        <tbody>
            <?php $accountStudent = 0; ?>
            <?php foreach ($estudiantesInscritos as $estudiante): ?> 
                <?php $accountStudent++; ?>
                    <tr>
                        <td><?= $accountStudent ?></td>
                        <td><?= $estudiante['cédula'] ?></td>
                        <td><?= $estudiante['apellido'] ?></td>
                        <td><?= $estudiante['nombre'] ?></td>
                        <td><?= $estudiante['grado'] ?></td>
                        <td><?= $estudiante['tipo_descuento'] ?></td>
                        <td><?= $estudiante['descuento'] ?></td>
                        <td><?= $estudiante['factura'] ?></td>
                        <td><?= $estudiante['transaccion'] ?></td>
                        <td><?= number_format($estudiante['monto'], 2, ",", ".") ?></td>					
                    </tr>
                <?php endforeach; ?>
        </tbody>
    </table>
    <p>Total general estudiantes inscritos a la fecha: <?= $contadorEstudiantes ?></p>
    <p>Total estudiantes inscritos desde septiembre: <?= $accountStudent ?></p>
</div>
<div id="menu-menos" class="menumenos nover">
    <p>
    <a href="#" id="mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger'></a>
    </p>
</div>
<div id="menu-mas" style="display:none;" class="menumas nover">
    <p>
        <a href="../users/wait" id="volver" title="Volver" class='glyphicon glyphicon-chevron-left btn btn-danger'></a>
        <a href="../users/wait" id="cerrar" title="Cerrar vista" class='glyphicon glyphicon-remove btn btn-danger'></a>
        <a href='#' id="excel" title="EXCEL" class='glyphicon glyphicon-list-alt btn btn-danger'></a>
        <a href='#' id="menos" title="Menos opciones" class='glyphicon glyphicon-minus btn btn-danger'></a>
    </p>
</div>
<script>
$(document).ready(function(){ 
    $('#mas').on('click',function()
    {
        $('#menu-menos').hide();
        $('#menu-mas').show();
    });
    
    $('#menos').on('click',function()
    {
        $('#menu-mas').hide();
        $('#menu-menos').show();
    });
    
    $("#excel").click(function(){
        
        $("#general").table2excel({
    
            exclude: ".noExl",
        
            name: "Alumnos inscritos desde septiembre",
        
            filename: "alumnos inscritos desde septiembre" 
    
        });
    });
});
</script>