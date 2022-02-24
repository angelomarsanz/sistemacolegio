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
										<th style="text-align: center;"><b>Bolívares</b></th>
										<th style="text-align: center;"><b>Dólares</b></th>
										<th style="text-align: center;"><b>Pesos</b></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$pagosBolivaresTotal = 0;
									$pagosDolaresTotal = 0;
									$pagosPesosTotal = 0;
									foreach ($documentosFiscales as $indice => $dia):
										$primerElemento 	= reset($dia);
										$primeraFacturaDia 	= $primerElemento['numero_factura'] . ' (' . $primerElemento['numero_control'] . ')';
										$ultimoElemento 	= end($dia);
										$ultimaFacturaDia 	= $ultimoElemento['numero_factura'] . ' (' . $ultimoElemento['numero_control'] . ')';
										$pagosBolivaresDia 	= 0;
										$pagosDolaresDia	= 0;
										$pagosPesosDia 		= 0;	
										foreach ($dia as $pago):
											if ($pago['anulado'] == 0):
												if ($pago['moneda'] == 'Bs.' && $pago['monto'] > 0):
													$pagosBolivaresDia += $pago['monto'];
													$pagosBolivaresTotal += $pago['monto'];
												elseif ($pago['moneda'] == '$' && $pago['monto'] > 0):
													$pagosDolaresDia += $pago['monto'];
													$pagosDolaresTotal += $pago['monto'];
												elseif ($pago['moneda'] == 'P' && $pago['monto'] > 0):
													$pagosPesosDia += $pago['monto'];
													$pagosPesosTotal += $pago['monto'];
												endif;
											endif;
										endforeach; ?>
										<tr>
											<td><?= $indice ?></td>
											<td><?= $primeraFacturaDia ?></td>
											<td><?= $ultimaFacturaDia ?></td>
											<td style="text-align: center;"><?= number_format($pagosBolivaresDia, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($pagosDolaresDia, 2, ",", ".") ?></td>
											<td style="text-align: center;"><?= number_format($pagosPesosDia, 2, ",", ".") ?></td>	
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
										<td style="text-align: center;"><b><?= number_format($pagosDolaresTotal, 2, ",", ".") ?></b></td>
										<td style="text-align: center;"><b><?= number_format($pagosPesosTotal, 2, ",", ".") ?></b></td>	
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