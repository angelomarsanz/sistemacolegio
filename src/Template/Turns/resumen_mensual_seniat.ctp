<?php
    use Cake\Routing\Router; 
	$diasMeses =
		[
			'01' => '31',
			'02' => '28',
			'03' => '31',
			'04' => '30',
			'05' => '31',
			'06' => '30',
			'07' => '31',
			'08' => '31',
			'09' => '30',
			'10' => '31',
			'11' => '30',
			'12' => '31'
		];
?>
<style>
@media screen
{
    .noverScreen
    {
      display:none
    }
}
@media print
{
	.saltopagina
	{
		display:block; 
		page-break-before:always;
	}
}
</style>
<?php
// var_dump($documentosFiscales); ?>
<div name="reporte_resumen_contabilidad" id="reporte_resumen_contabilidad" class="container" style="font-size: 12px; line-height: 14px;">
	<br />
    <div class="row">
        <div class="col-md-12">
			<div>
				<table style="width:100%; font-size: 14px; line-height: 16px;">
					<tbody>
						<tr>
							<td>Unidad Educativa Fundación</td>
						</tr>
						<tr>
							<td><b>"Colegio Verdad y Libertad"</b></td>
						</tr>
						<tr>
							<td><b>"RIF: J-30649093-0"</b></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>		
					</tbody>
				</table>
			</div>
			<div>	
				<div>
					<div class="row">
						<div class="col-md-12">					
							<table>
								<thead>
									<tr>
										<th style="font-size: 18px; line-height: 20px;"><b>RELACIÓN DE VENTAS DEL <?= '01/'.$mes.'/'.$ano ?> AL <?= $diasMeses[$mes].'/'.$mes.'/'.$ano ?></b></th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>			
				<div>
					<br />
					<div class="row">
						<div class="col-md-12">					
							<table class="table table-striped table-hover">
								<thead>	
									<tr>
										<th><b>Fecha</b></th>
										<th><b>Factura (control) desde</b></th>
										<th><b>Factura (control) hasta</b></th>
										<th style="text-align: center;"><b>Monto en Bolívares</b></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$montoBolivaresTotal = 0;
									foreach ($documentosFiscales as $indice => $dia):
										$primerElemento 	= reset($dia);
										$primeraFacturaDia 	= $primerElemento['numero_factura'] . ' (' . $primerElemento['numero_control'] . ')';
										$ultimoElemento 	= end($dia);
										$ultimaFacturaDia 	= $ultimoElemento['numero_factura'] . ' (' . $ultimoElemento['numero_control'] . ')';
										$MontoBolivaresDia 	= 0;
										foreach ($dia as $monto):
											if ($monto['anulado'] == 0):
												if ($monto['monto'] > 0):
													$montoBolivaresDia += $pago['monto'];
													$montoBolivaresTotal += $pago['monto'];
												endif;
											endif;
										endforeach; ?>
										<tr>
											<td><?= $indice ?></td>
											<td><?= $primeraFacturaDia ?></td>
											<td><?= $ultimaFacturaDia ?></td>
											<td style="text-align: center;"><?= number_format($pagosBolivaresDia, 2, ",", ".") ?></td>
										</tr>
									<?php
									endforeach; ?>
								</tbody>
								<tfoot>
									<tr>
										<td></td>
										<td></td>
										<td><b>Totales</b></td>
										<td style="text-align: center;"><b><?= number_format($pagosBolivaresTotal, 2, ",", ".") ?></b></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>            
</div>   
<script>
    $(document).ready(function() 
    {
		$("#exportar-excel").click(function(){
			
			$("#reporte_resumen_contabilidad").table2excel({
		
				exclude: ".noExl",
			
				name: "reporte_resumen_contabilidad",
			
				filename: $('#reporte_resumen_contabilidad').attr('name') 
		
			});
		});
    });
        
</script>