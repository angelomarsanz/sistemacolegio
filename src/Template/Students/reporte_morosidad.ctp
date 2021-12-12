<?php
    use Cake\Routing\Router;
?>
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
<br />
<div class="row">
	<div class="col-md-12">
		<?php if ($tipoReporte == "Por grado"): ?>
			<div>
				<div style="float: left; width:10%;">
					<p><img src="<?php echo Router::url(["controller" => "files", "action" => "schools"]) . '/profile_photo/f0c3559c-c419-42ee-b586-e16819cf7416/Logo CvyL.png'; ?>" width = 50 height = 50 class="img-thumbnail img-responsive logo"/></p>
				</div>
				<div style="float: left; width: 90%;">
					<p style="text-align: right;">Página 1</p>
					<h5><b><?= $school->name ?></b></h5>
					<p>RIF: <?= $school->rif ?></p>
					<p>Fecha de emisión: <?= $currentDate->format('d/m/Y'); ?></p>
					<h3 style="text-align: center;"><?= 'Reporte de Morosidad al ' . $mes . "/" . $ano ?> </h3>
				</div>
			</div>
			<div>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th style="text-align:center;"></th>
							<th colspan="5" style="text-align:center;">Alumnos</th>
						</tr>
						<tr>
							<th style="text-align:center;">Grado</th>
							<th style="text-align:center;">Morosos</th>
							<th style="text-align:center;">Solventes</th>
							<th style="text-align:center;">Becados 100%</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<td style='text-align:left;'><b>Totales</b></td>
							<td style='text-align:center;'><b><?= h($tDefaulters[0]['defaulters']) ?></b></td>
							<td style='text-align:center;'><b><?= h($tDefaulters[0]['solvents']) ?></b></td>
							<td style='text-align:center;'><b><?= h($tDefaulters[0]['scholarship']) ?></b></td>
						</tr>
					</tfoot>
					<tbody>
						<?php foreach ($defaulters as $defaulter): ?>
							<tr>
								<td style='text-align:left;'><?= h($defaulter['section']) ?></td>
								<td style='text-align:center;'><?= h($defaulter['defaulters']) ?></td>
								<td style='text-align:center;'><?= h($defaulter['solvents']) ?></td>
								<td style='text-align:center;'><?= h($defaulter['scholarship']) ?></td>
							</tr>  
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div class="saltopagina">
				<div style="float: left; width:10%;">
					<p><img src="<?php echo Router::url(["controller" => "files", "action" => "schools"]) . '/profile_photo/f0c3559c-c419-42ee-b586-e16819cf7416/Logo CvyL.png'; ?>" width = 50 height = 50 class="img-thumbnail img-responsive logo"/></p>
				</div>
				<div style="float: left; width: 90%;">
					<p style="text-align: right;">Página 2</p>
					<h5><b><?= $school->name ?></b></h5>
					<p>RIF: <?= $school->rif ?></p>
					<p>Fecha de emisión: <?= $currentDate->format('d/m/Y'); ?></p>
					<h3 style="text-align: center;"><?= 'Reporte de Morosidad al ' . $mes . "/" . $ano ?> </h3>
				</div>
			</div>
			<div style="clear: both;">
				<br />
				<br />
				<p><b><?= 'Total morosidad a la fecha Bs.S ' . number_format($totalDebt, 2, ",", ".") ?><b></p>
				<p><b><?= 'Total alumnos morosos: ' . $tDefaulters[0]['defaulters'] . " (" . number_format((($tDefaulters[0]['defaulters']/$tDefaulters[0]['totalStudents'])*100), 2, ",", ".") . '%)' ?><b></p>
				<p><b><?= 'Total alumnos solventes: ' . $tDefaulters[0]['solvents'] . " (" . number_format((($tDefaulters[0]['solvents']/$tDefaulters[0]['totalStudents'])*100), 2, ",", ".") . '%)' ?><b></p>
				<p><b><?= 'Total alumnos becados 100%: ' . $tDefaulters[0]['scholarship'] . " (" . number_format((($tDefaulters[0]['scholarship']/$tDefaulters[0]['totalStudents'])*100), 2, ",", ".") . '%)' ?><b></p>
				<br />
				<br />
			</div>
		<?php elseif ($tipoReporte == "Total general"): ?>
			<div>
				<div style="float: left; width:10%;">
					<p><img src="<?php echo Router::url(["controller" => "files", "action" => "schools"]) . '/profile_photo/f0c3559c-c419-42ee-b586-e16819cf7416/Logo CvyL.png'; ?>" width = 50 height = 50 class="img-thumbnail img-responsive logo"/></p>
				</div>
				<div style="float: left; width: 90%;">
					<p style="text-align: right;">Página 2</p>
					<h5><b><?= $school->name ?></b></h5>
					<p>RIF: <?= $school->rif ?></p>
					<p>Fecha de emisión: <?= $currentDate->format('d/m/Y'); ?></p>
					<h3 style="text-align: center;"><?= 'Reporte de Morosidad al ' . $mes . "/" . $ano ?> </h3>
				</div>
			</div>
			<div style="clear: both;">
				<br />
				<br />
				<p><b><?= 'Total morosidad a la fecha Bs.S ' . number_format($totalDebt, 2, ",", ".") ?><b></p>
				<p><b><?= 'Total alumnos morosos: ' . $tDefaulters[0]['defaulters'] . " (" . number_format((($tDefaulters[0]['defaulters']/$tDefaulters[0]['totalStudents'])*100), 2, ",", ".") . '%)' ?><b></p>
				<p><b><?= 'Total alumnos solventes: ' . $tDefaulters[0]['solvents'] . " (" . number_format((($tDefaulters[0]['solvents']/$tDefaulters[0]['totalStudents'])*100), 2, ",", ".") . '%)' ?><b></p>
				<p><b><?= 'Total alumnos becados 100%: ' . $tDefaulters[0]['scholarship'] . " (" . number_format((($tDefaulters[0]['scholarship']/$tDefaulters[0]['totalStudents'])*100), 2, ",", ".") . '%)' ?><b></p>
				<br />
				<br />
			</div>
		<?php elseif ($tipoReporte == "Por alumno"): 
			$contadorAlumnosMorosos = 1; ?>
			<div>
				<div style="float: left; width:10%;">
					<p><img src="<?php echo Router::url(["controller" => "files", "action" => "schools"]) . '/profile_photo/f0c3559c-c419-42ee-b586-e16819cf7416/Logo CvyL.png'; ?>" width = 50 height = 50 class="img-thumbnail img-responsive logo"/></p>
				</div>
				<div style="float: left; width: 90%;">
					<p style="text-align: right;">Página 1</p>
					<h5><b><?= $school->name ?></b></h5>
					<p>RIF: <?= $school->rif ?></p>
					<p>Fecha de emisión: <?= $currentDate->format('d/m/Y'); ?></p>
					<h3 style="text-align: center;"><?= 'Reporte de alumnos Morosos al ' . $mes . "/" . $ano ?> </h3>
				</div>
			</div>
			<div>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th style="text-align:center;">Nro.</th>
							<th style="text-align:center;">Grado</th>
							<th style="text-align:center;">Alumno</th>
							<th style="text-align:center;">Descuento (%)</th>
							<th style="text-align:center;">Cuotas pendientes</th>
							<th style="text-align:center;">Monto en $</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($detalleMorosos as $clave => $moroso): ?>
							<tr>
								<td style='text-align:left;'><?= $contadorAlumnosMorosos ?></td>
								<td style='text-align:center;'><?= $moroso['grado'] ?></td>
								<td style='text-align:left;'><?= $clave ?></td>
								<td style='text-align:center;'><?= $moroso['descuento'] ?></td>
								<td style='text-align:center;'><?= $moroso['cuotasPendientes'] ?></td>
								<td style='text-align:center;'><?= number_format($moroso['pendiente'], 2, ",", ".") ?></td>
							</tr> 
							<?php $contadorAlumnosMorosos++; 
						endforeach; ?>
					</tbody>
					<tfoot>
						<tr>
							<td style='text-align:left;'><b>Total Bs.</b></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td style='text-align:center;'><b><?= number_format($totalMoroso, 2, ",", ".") ?></b></td>

						</tr>
					</tfoot>
				</table>
		<?php elseif ($tipoReporte == "Aviso de cobro"): ?>
			<?php $contadorAlumnosImpresos = 0; ?>
			<?php $contadorSaltoPagina = 0; ?>
			<?php $gradoAnterior = '' ?>;
			<?php $contadorGrado = 0; ?>
			<?php foreach ($detalleMorosos as $clave => $moroso): ?>
				<?php $contadorAlumnosImpresos++; ?>
				<?php // if ($contadorAlumnosImpresos == 20): ?>
					<?php // break; ?>
				<?php // endif; ?>

				<?php if ($contadorGrado == 0): ?>
					<?php $gradoAnterior = $moroso['grado']; ?>
					<div>
						<h1 style="text-align: center;"><b><?= $moroso['grado']; ?></b></h1>	
					</div>
					<?php $contadorSaltoPagina = 2 ?>
				<?php endif; ?>

				<?php $contadorGrado++; ?>

				<?php if ($gradoAnterior != $moroso['grado']): ?>
					<?php $gradoAnterior = $moroso['grado']; ?>
					<div class="saltopagina">
						<h1 style="text-align: center;"><b><?= $moroso['grado']; ?></b></h1>	
					</div>
					<?php $contadorSaltoPagina = 2 ?>
				<?php endif; ?>

				<?php if ($contadorSaltoPagina == 2): ?>
					<div class="saltopagina">
					<?php $contadorSaltoPagina = 1 ?>
				<?php else: ?>
					<?php $contadorSaltoPagina++; ?>
					<div>
				<?php endif; ?>
						<p><img src="<?php echo Router::url(["controller" => "files", "action" => "schools"]) . '/profile_photo/f0c3559c-c419-42ee-b586-e16819cf7416/Logo CvyL.png'; ?>" width = 50 height = 50 class="img-thumbnail img-responsive logo"/></p>
						<h5><b><?= $school->name ?></b></h5>
						<p>RIF: <?= $school->rif ?></p>
						<p>Fecha de emisión: <?= $currentDate->format('d/m/Y'); ?></p>
						<h4 style="text-align: center;"><b>Aviso de Cobro - <?= $moroso['grado'] ?></b></h4>
						<h5><?= 'Estudiante: ' . $clave . ' Representante: ' . $moroso['nombreRepresentante'] . ' ' . $moroso['cedulaRepresentante'] ?></h5> 
						<p>Estimado representante, a la presente fecha usted tiene <?= $moroso['cuotasPendientes'] ?> cuotas vencidas por un monto total de: <?= number_format($moroso['pendiente'], 2, ",", ".") ?> $ USD, correspondientes al estudiante <?= $clave ?>. Le agradecemos cancelar a la brevedad posible.</p>
						<p>Atentamente, </p>
						<p>Por el Departamento de Administración del Colegio Verdad y Libertad</p>
						<p>Firma y sello:</p> 
						<br />
						<br />
						<p>------------------------------------------------------------------------------------------------------</p>
						<br />
						<br />
					</div>
			<?php endforeach; ?> 
		<?php else: ?>
			<a href='#' id="excel" title="EXCEL" class='btn btn-success'>Descargar reporte en excel</a>
			<div>
				<table id="representantes" name="representantes" class="table table-striped table-hover">
					<thead>
						<tr>
							<th style="text-align:center;"></th>
							<th><b>Representantes con cuotas pendientes</b></th>
						</tr>
						<tr>
							<th style="text-align:center;">Grado</th>
							<th style="text-align:center;">Cédula</th>
							<th style="text-align:center;">Representantes</th>
							<th style="text-align:center;">Cuotas</th>
							<th style="text-align:center;">Monto</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($detalleMorosos as $clave => $moroso): ?>
							<tr>
								<td style='text-align:left;'><?= h($moroso['grado']) ?></td>
								<td style='text-align:center;'><?= h($moroso['cedulaRepresentante']) ?></td>
								<td style='text-align:center;'><?= h($moroso['nombreRepresentante']) ?></td>
								<td style='text-align:center;'><?= h($moroso['cuotasPendientes']) ?></td>
								<td style='text-align:center;'><?= h($moroso['pendiente']) ?></td>
							</tr>  
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
		<br />			
	</div>
</div>
<div id="menu-menos" class="menumenos nover">
    <p>
    <a href="#" id="mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger'></a>
    </p>
</div>
<div id="menu-mas" style="display:none;" class="menumas nover">
    <p>
        <a href="<?= Router::url(["controller" => "Users", "action" => "wait"]) ?>" id="volver" title="Volver" class='glyphicon glyphicon-chevron-left btn btn-danger'></a>
        <a href="<?= Router::url(["controller" => "Users", "action" => "wait"]) ?>" id="cerrar" title="Cerrar vista" class='glyphicon glyphicon-remove btn btn-danger'></a>
         <a href='#' id="menos" title="Menos opciones" class='glyphicon glyphicon-minus btn btn-danger'></a>
    </p>
</div>
<script>
function myFunction() 
{
    window.print();
}
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
        
        $("#representantes").table2excel({
    
            exclude: ".noExl",
        
            name: "representantes",
        
            filename: $('#representantes').attr('name') 
    
        });
    });
});
</script>