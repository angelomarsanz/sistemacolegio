<?php
    use Cake\Routing\Router; 
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
<?php $contadorLineasCuotas = 1; ?>
<div name="reporte_cierre" id="reporte-cierre" class="container" style="font-size: 12px; line-height: 14px;">
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
							<td>&nbsp;</td>
						</tr>	
						<tr>
							<td><b>Turno <?= $turn->turn ?>, de fecha: <?= $turn->start_date->format('d-m-Y') ?>, correspondiente al cajero <?= $cajero ?></b></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>							
						<tr>
							<td><b>Tasa Oficial Dólar: <?= number_format($tasaDolar, 2, ",", ".") ?> - Tasa de cambio Pesos: <?= number_format($tasaEuro, 2, ",", ".") ?></b></td>
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
										<th style="font-size: 18px; line-height: 20px;"><b>PAGOS FISCALES</b></th>
									</tr>
									<tr>
										<th>&nbsp;</th>
									</tr>
									<tr>
										<th style="font-size: 14px; line-height: 16px;"><b>&nbsp;&nbsp;&nbsp;RECIBIDO EN:</b></th>
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
										<th><b>Concepto</th>
										<th style="text-align: center;"><b>Efvo $</b></th>
										<th style="text-align: center;"><b>Efvo €</b></th>
										<th style="text-align: center;"><b>Efvo Bs.</b></th>
										<th style="text-align: center;"><b>TDB/TDC Bs.</b></th>
										<th style="text-align: center;"><b>Trans $</b></th>
										<th style="text-align: center;"><b>Trans P</b></th>
										<th style="text-align: center;"><b>Trans Bs.</b></th>
										<th style="text-align: center;"><b>Dep Bs.</b></th>
										<th style="text-align: center;"><b>Chq Bs.</b></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($vectorTotalesRecibidos as $clave => $recibido):
										if ($clave == "Menos reintegros"):
											$reintegroEfectivoDolar = $recibido['Efectivo $'];
											$reintegroEfectivoEuro = $recibido['Efectivo €'];
											$reintegroEfectivoBolivar = $recibido['Efectivo Bs.'];
											$reintegroZelle = $recibido['Zelle $'];
											if (isset($recibido['Euros €'])):
												$reintegroEuros = $recibido['Euros €'];
											else:
												$reintegroEuros = 0;
											endif;
											$reintegroTdbTdc = $recibido['TDB/TDC Bs.'];
											$reintegroTransferencia = $recibido['Transferencia Bs.'];
											$reintegroDeposito = $recibido['Depósito Bs.'];
											$reintegroCheque = $recibido['Cheque Bs.'];										
										else:
											if ($clave == 'Total recibido de ' . $cajero || $clave == "Diferencia"): ?>
												<tr>
													<td><?= $clave ?></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr> 
											<?php elseif ($clave == 'Total facturas + anticipos de inscripción'): ?> 												
												<tr>
													<td><b><?= $clave ?></b></td>
													<td style="text-align: center;"><b><?= number_format($recibido['Efectivo $'], 2, ",", ".") ?></b></td>
													<td style="text-align: center;"><b><?= number_format($recibido['Efectivo €'], 2, ",", ".") ?></b></td>
													<td style="text-align: center;"><b><?= number_format($recibido['Efectivo Bs.'], 2, ",", ".") ?></b></td>
													<td style="text-align: center;"><b><?= number_format($recibido['TDB/TDC Bs.'], 2, ",", ".") ?></b></td>
													<td style="text-align: center;"><b><?= number_format($recibido['Zelle $'], 2, ",", ".") ?></b></td>
													<?php if (isset($recibido['Euros €'])): ?>
														<td style="text-align: center;"><b><?= number_format($recibido['Euros €'], 2, ",", ".") ?></b></td>
													<?php else: ?>
														<td style="text-align: center;"><b><?= "0,00" ?></b></td>
													<?php endif; ?>
													<td style="text-align: center;"><b><?= number_format($recibido['Transferencia Bs.'], 2, ",", ".") ?></b></td>
													<td style="text-align: center;"><b><?= number_format($recibido['Depósito Bs.'], 2, ",", ".") ?></b></td>
													<td style="text-align: center;"><b><?= number_format($recibido['Cheque Bs.'], 2, ",", ".") ?></b></td>
												</tr>		
											<?php elseif ($clave == "Total a recibir de " . $cajero): ?>
												<tr>
													<td><b><?= $clave ?></b></td>
													<td style="text-align: center;"><b><?= number_format($recibido['Efectivo $'] - $reintegroEfectivoDolar, 2, ",", ".") ?></b></td>
													<td style="text-align: center;"><b><?= number_format($recibido['Efectivo €'] - $reintegroEfectivoEuro, 2, ",", ".") ?></b></td>
													<td style="text-align: center;"><b><?= number_format($recibido['Efectivo Bs.'] - $reintegroEfectivoBolivar, 2, ",", ".") ?></b></td>
													<td style="text-align: center;"><b><?= number_format($recibido['TDB/TDC Bs.'] - $reintegroTdbTdc, 2, ",", ".") ?></b></td>
													<td style="text-align: center;"><b><?= number_format($recibido['Zelle $'] - $reintegroZelle, 2, ",", ".") ?></b></td>
													<?php if (isset($recibido['Euros €'])): ?>
														<td style="text-align: center;"><b><?= number_format($recibido['Euros €'] - $reintegroEuros, 2, ",", ".") ?></b></td>
													<?php else: ?>
														<td style="text-align: center;"><b><?= "0,00" ?></b></td>
													<?php endif; ?>
													<td style="text-align: center;"><b><?= number_format($recibido['Transferencia Bs.'] - $reintegroTransferencia, 2, ",", ".") ?></b></td>
													<td style="text-align: center;"><b><?= number_format($recibido['Depósito Bs.'] - $reintegroDeposito, 2, ",", ".") ?></b></td>
													<td style="text-align: center;"><b><?= number_format($recibido['Cheque Bs.'] - $reintegroCheque, 2, ",", ".") ?></b></td>
												</tr>														
											<?php else: ?>
												<tr>
													<td><?= $clave ?></td>
													<td style="text-align: center;"><?= number_format($recibido['Efectivo $'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($recibido['Efectivo €'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($recibido['Efectivo Bs.'], 2, ",", ".") ?></td>													
													<td style="text-align: center;"><?= number_format($recibido['TDB/TDC Bs.'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($recibido['Zelle $'], 2, ",", ".") ?></td>
													<?php if (isset($recibido['Euros €'])): ?>
														<td style="text-align: center;"><?= number_format($recibido['Euros €'], 2, ",", ".") ?></td>
													<?php else: ?>
														<td style="text-align: center;"><?= "0,00" ?></td>
													<?php endif; ?>													
													<td style="text-align: center;"><?= number_format($recibido['Transferencia Bs.'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($recibido['Depósito Bs.'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($recibido['Cheque Bs.'], 2, ",", ".") ?></td>
												</tr>
											<?php endif;
										endif;
									endforeach; ?>	
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div>
					<div class="row">
						<div class="col-md-12">					
							<table>
								<thead>
									<tr>
										<th>&nbsp;</th>
									</tr>	
									<tr>
										<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE FACTURAS:</b></th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
				<div>
					<div class="row">
						<div class="col-md-12">					
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th style="text-align: center;"><b>Familia</b></th>
										<th style="text-align: center;"><b>Ctrol / Fact</b></th>
										<th style="text-align: center;"><b>Tipo doc</b></th>
										<th style="text-align: center;"><b>Fact $</b></th>
										<th style="text-align: center;"><b>Fact Bs.</b></th>
										<th style="text-align: center;"><b>Desc / Rec</b></th>
										<th style="text-align: center;"><b>Tasa $ / P</b></th>
										<th style="text-align: center;"><b>E $</b></th>
										<th style="text-align: center;"><b>E €</b></th>
										<th style="text-align: center;"><b>E Bs.</b></th>
										<th style="text-align: center;"><b>TD/TC Bs.</b></th>
										<th style="text-align: center;"><b>Trans $</b></th>
										<th style="text-align: center;"><b>Trans P</b></th>
										<th style="text-align: center;"><b>Trans Bs.</b></th>
										<th style="text-align: center;"><b>Dep Bs.</b></th>
										<th style="text-align: center;"><b>Chq Bs.</b></th>
										<th style="text-align: center;"><b>Tot Cob. Bs.</b></th>
										<th style="text-align: center;"><b>Comp Bs.</b></th>
										<th style="text-align: center;"><b>Dif Bs.</b></th>
										<th style="text-align: center;"><b>TCM</b></th>
									</tr>
								</thead>
								<tbody>				
									<?php $cobradoBolivares = 0; 
									$totalCobradoBolivares = 0;
									$totalFacturaDolar = 0;
									$totalFacturaBolivar = 0; 
									$totalEfectivoDolar = 0;
									$totalEfectivoEuro = 0;
									$totalEfectivoBolivar = 0;
									$totalZelle = 0;
									$totalEuros = 0;
									$totalTdbTdc = 0;
									$totalTransferencias = 0;
									$totalDepositos = 0;
									$totalCheques = 0;
									$compensado = 0;
									$totalCompensado = 0;
									$diferencia = 0;
									$totalDiferencia = 0;
									$totalDescuentosRecargosFA = 0;
									foreach ($vectorPagos as $pago): 
										$transferenciaDestiempo = "";
										$cuotasAlumnoBecado = "";
										$cambioMontoCuota = "";
										$facturaDeAnticipo = 0;
										if (isset($pago['facturaDeAnticipo'])):
											$facturaDeAnticipo = $pago['facturaDeAnticipo'];
										endif;
										if ($facturaDeAnticipo == 0):
											if ($pago['tipoDocumento'] == "Factura" || $pago['tipoDocumento'] == "Recibo de anticipo"): ?> 
												<tr>
													<td><?= $pago['familia']; ?></td>
													<td style="text-align: center;"><?= $pago['nroControl'] . " " . $pago['nroFactura']; ?></td>
													<?php if ($pago['tipoDocumento'] == "Factura"): ?>
														<td style="text-align: center;">F</td>
													<?php else: ?>
														<td style="text-align: center;">R</td>
													<?php endif; ?>
													<td style="text-align: center;"><?= number_format(round($pago['totalFacturaDolar'] - $pago['compensadoDolar'], 2), 2, ",", ".") ?></td>
													<?php $compensado = round($pago['compensadoDolar'] * $pago['tasaDolar'], 2); ?>
													<td style="text-align: center;"><?= number_format($pago['totalFacturaBolivar'] - $compensado, 2, ",", ".") ?></td>
													<?php if (isset($pago['descuentoRecargo'])): ?>
														<td style="text-align: center;"><?= number_format($pago['descuentoRecargo'], 2, ",", ".") ?></td>
													<?php else: ?>
														<td style="text-align: center;">0,00</td>
													<?php endif; ?>
													<td style="text-align: center;"><?= number_format($pago['tasaDolar'], 2, ",", ".") . " " . number_format($pago['tasaEuro'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($pago['efectivoDolar'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($pago['efectivoEuro'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($pago['efectivoBolivar'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($pago['tddTdcBolivar'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($pago['zelleDolar'], 2, ",", ".") ?></td>
													<?php if (isset($pago['euros'])): ?>
														<td style="text-align: center;"><?= number_format($pago['euros'], 2, ",", ".") ?></td>
													<?php else: ?>
														<td style="text-align: center;"><?= "0,00" ?></td>
													<?php endif; ?>
													<td style="text-align: center;"><?= number_format($pago['transferenciaBolivar'], 2, ",", ".") ?></td>										
													<td style="text-align: center;"><?= number_format($pago['depositoBolivar'], 2, ",", ".") ?></td>
													<td style="text-align: center;"><?= number_format($pago['chequeBolivar'], 2, ",", ".") ?></td>
													<?php $cobradoBolivares = 
														round(($pago['efectivoDolar'] + $pago['zelleDolar']) * $pago['tasaDolar'], 2) +
														round(($pago['efectivoEuro'] / $pago['tasaEuro']) * $pago['tasaDolar'], 2) +
														$pago['efectivoBolivar'] + 
														$pago['tddTdcBolivar'] + 
														$pago['transferenciaBolivar'] +
														$pago['depositoBolivar'] +
														$pago['chequeBolivar']; 
														if (isset($pago['euros'])): 
															$cobradoBolivares += round(($pago['euros'] / $pago['tasaEuro']) * $pago['tasaDolar'], 2); 
														endif; ?>														
													<td style="text-align: center;"><?= number_format($cobradoBolivares, 2, ",", ".") ?></td>
													
													<td style="text-align: center;"><?= number_format($compensado, 2, ",", ".") ?></td>
													<?php if (isset($pago['descuentoRecargo'])):
														$diferencia = $pago['totalFacturaBolivar'] + $pago['descuentoRecargo'] - $compensado - $cobradoBolivares;
													else: 
														$diferencia = $pago['totalFacturaBolivar'] - $compensado -  $cobradoBolivares;													
													endif; ?>
													<td style="text-align: center;"><?= number_format($diferencia, 2, ",", ".") ?></td>
													<?php if (isset($pago['tasaTemporalDolar'])):
														if ($pago['tasaTemporalDolar'] == 1):
															$transferenciaDestiempo = "T";
														endif;
													endif;
													if (isset($pago['tasaTemporalEuro'])):
														if ($pago['tasaTemporalEuro'] == 1):
															$transferenciaDestiempo = "T";
														endif;
													endif;
													if (isset($pago['cuotasAlumnoBecado'])):
														if ($pago['cuotasAlumnoBecado'] > 0):
															$cuotasAlumnoBecado = "C";
														endif;
													endif;
													if (isset($pago['cambioMontoCuota'])):
														if ($pago['cambioMontoCuota'] == 1):
															$cambioMontoCuota = "M";
														endif;
													endif; ?>
													<td style="text-align: center;"><?= $transferenciaDestiempo . $cuotasAlumnoBecado . $cambioMontoCuota; ?></td>
												</tr>
												<?php $totalFacturaDolar += ($pago['totalFacturaDolar'] - $pago['compensadoDolar']);  
												$totalFacturaBolivar += $pago['totalFacturaBolivar'] - $compensado; 
												if (isset($pago['descuentoRecargo'])): 
													$totalDescuentosRecargosFA += $pago['descuentoRecargo'];
												endif;
												$totalEfectivoDolar += $pago['efectivoDolar'];
												$totalEfectivoEuro += $pago['efectivoEuro'];
												$totalEfectivoBolivar += $pago['efectivoBolivar'];
												$totalZelle += $pago['zelleDolar'];
												if (isset($pago['euros'])):
													$totalEuros += $pago['euros'];
												endif; 
												$totalTdbTdc += $pago['tddTdcBolivar'];
												$totalTransferencias += $pago['transferenciaBolivar'];
												$totalDepositos += $pago['depositoBolivar'];
												$totalCheques += $pago['chequeBolivar'];
												$totalCobradoBolivares += $cobradoBolivares;
												$totalCompensado += $compensado;
												$totalDiferencia += $diferencia;
											endif;
										endif;
									endforeach; ?>
									<tr>
										<td><b>Totales</b></td>
										<td></td>
										<td></td>
										<td style="text-align: center;"><b><?= number_format($totalFacturaDolar, 2, ",", ".") ?></b></td>
										<td style="text-align: center;"><b><?= number_format($totalFacturaBolivar, 2, ",", ".") ?></b></td>												
										<td style="text-align: center;"><b><?= number_format($totalDescuentosRecargosFA, 2, ",", ".") ?></b></td>	
										<td></td>
										<td style="text-align: center;"><b><?= number_format($totalEfectivoDolar, 2, ",", ".") ?></b></td>
										<td style="text-align: center;"><b><?= number_format($totalEfectivoEuro, 2, ",", ".") ?></b></td>
										<td style="text-align: center;"><b><?= number_format($totalEfectivoBolivar, 2, ",", ".") ?></b></td>
										<td style="text-align: center;"><b><?= number_format($totalTdbTdc, 2, ",", ".") ?></b></td>
										<td style="text-align: center;"><b><?= number_format($totalZelle, 2, ",", ".") ?></b></td>
										<td style="text-align: center;"><b><?= number_format($totalEuros, 2, ",", ".") ?></b></td>
										<td style="text-align: center;"><b><?= number_format($totalTransferencias, 2, ",", ".") ?></b></td>										
										<td style="text-align: center;"><b><?= number_format($totalDepositos, 2, ",", ".") ?></b></td>
										<td style="text-align: center;"><b><?= number_format($totalCheques, 2, ",", ".") ?></b></td>
										<td style="text-align: center;"><b><?= number_format($totalCobradoBolivares, 2, ",", ".") ?></b></td>
										<td style="text-align: center;"><b><?= number_format($totalCompensado, 2, ",", ".") ?></b></td>
										<td style="text-align: center;"><b><?= number_format($totalDiferencia, 2, ",", ".") ?></b></td>
										<td></td>											
									</tr>
									<tr>
										<td><i>Leyenda: T = Transferencia destiempo, C = Convenio y M = Cambio monto cuota</i></td>
										<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										<td></td><td></td><td></td><td></td><td></td><td></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>	
							
				<div class="saltopagina">
					<div class="row">
						<div class="col-md-12">					
							<table>
								<thead>
									<tr>
										<th>&nbsp;</th>
									</tr>	
									<tr>
										<th style="font-size: 14px; line-height: 16px;"><b><?= 'Pago de Matrícula Año Escolar Actual' ?></b></th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
				<?php $contadorLineasCuotas++; ?>
				<div>
					<div class="row">
						<div class="col-md-12">					
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th style="text-align: center;"><b>Nro.</b></th>
										<th style="text-align: center;"><b>Nro. Factura</b></th>
										<th style="text-align: center;"><b>Nro. Control</b></th>
										<th style="text-align: center;"><b>Cedula/Rif</b></th>
										<th style="text-align: center;"><b>Nombre o razón social</b></th>
										<th style="text-align: center;"><b>Concepto</b></th>
										<th style="text-align: center;"><b>Monto Bs.</b></th>
										<th style="text-align: center;"><b>Observación</b></th>
									</tr>
								</thead>
								<?php $contadorLineasCuotas++; ?>
								<tbody>				
									<?php $contadorMatriculaActual = 0;
									$totalMatriculaActual = 0; 
									$actualAnoEscolar = $schools->current_school_year;
									foreach ($soloFacturas as $factura):
										if (substr($factura->school_year, 13, 4) == $actualAnoEscolar):
											foreach ($vectorConceptos as $concepto):
												if ($concepto['idFactura'] == $factura->id):
													if ($concepto['concepto'] == 'Matrícula '.$actualAnoEscolar): 
														$contadorMatriculaActual++; ?>
														<tr>
															<td style="text-align: center;"><?= $contadorMatriculaActual; ?></td>
															<td style="text-align: center;"><?= $factura->bill_number; ?></td>
															<td style="text-align: center;"><?= $factura->control_number; ?></td>
															<td style="text-align: center;"><?= $factura->identification; ?></td>
															<td style="text-align: center;"><?= $factura->client; ?></td>
															<td style="text-align: center;"><?= $concepto['concepto']; ?></td>
															<td style="text-align: center;"><?= number_format($concepto['monto'], 2, ",", "."); ?></td>
															<td style="text-align: center;"><?= $concepto['observacion']; ?></td>
														</tr>
														<?php $contadorLineasCuotas++; ?>
														<?php $totalMatriculaActual = $totalMatriculaActual + $concepto['monto'];
													endif;
												endif;
											endforeach;
										endif;
									endforeach ?>
									<tr>
										<td><b>Totales</b></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td style="text-align: center;"><?= number_format($totalMatriculaActual, 2, ",", "."); ?></td>
										<td></td>
									</tr>
									<?php $contadorLineasCuotas++; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<?php
				if ($contadorLineasCuotas >= 30):
					$contadorLineasCuotas = 1 ?>
					<div class="saltopagina">
				<?php
				else: ?>		
					<div>
				<?php
				endif; ?>
					<div class="row">
						<div class="col-md-12">					
							<table>
								<thead>
									<tr>
										<th>&nbsp;</th>
									</tr>	
									<tr>
										<th style="font-size: 14px; line-height: 16px;"><b><?= 'Pago de Mensualidades Año Escolar Actual' ?></b></th>
									</tr>
								</thead>
							</table>
							<?php $contadorLineasCuotas++; ?>
						</div>
					</div>
				</div>
				<div>
					<div class="row">
						<div class="col-md-12">					
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th style="text-align: center;"><b>Nro.</b></th>
										<th style="text-align: center;"><b>Nro. Factura</b></th>
										<th style="text-align: center;"><b>Nro. Control</b></th>
										<th style="text-align: center;"><b>Cedula/Rif</b></th>
										<th style="text-align: center;"><b>Nombre o razón social</b></th>
										<th style="text-align: center;"><b>Concepto</b></th>
										<th style="text-align: center;"><b>Monto Bs.</b></th>
										<th style="text-align: center;"><b>Observación</b></th>
									</tr>
								</thead>
								<?php $contadorLineasCuotas++; ?>
								<tbody>				
									<?php $contadorMensualidadesActual = 0;
									$totalMensualidadesActual = 0; 
									$actualAnoEscolar = $schools->current_school_year;
									foreach ($soloFacturas as $factura):
										if (substr($factura->school_year, 13, 4) == $actualAnoEscolar):
											foreach ($vectorConceptos as $concepto):
												if ($concepto['idFactura'] == $factura->id):
													if ($concepto['concepto'] != 'Matrícula '.$actualAnoEscolar): 
														$contadorMensualidadesActual++; ?>
														<tr>
															<td style="text-align: center;"><?= $contadorMensualidadesActual; ?></td>
															<td style="text-align: center;"><?= $factura->bill_number; ?></td>
															<td style="text-align: center;"><?= $factura->control_number; ?></td>
															<td style="text-align: center;"><?= $factura->identification; ?></td>
															<td style="text-align: center;"><?= $factura->client; ?></td>
															<td style="text-align: center;"><?= $concepto['concepto']; ?></td>
															<td style="text-align: center;"><?= number_format($concepto['monto'], 2, ",", "."); ?></td>
															<td style="text-align: center;"><?= $concepto['observacion']; ?></td>
														</tr>
														<?php $contadorLineasCuotas++; ?>
														<?php $totalMensualidadesActual = $totalMensualidadesActual + $concepto['monto'];
													endif;
												endif;
											endforeach;
										endif;
									endforeach ?>
									<tr>
										<td><b>Totales</b></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td style="text-align: center;"><?= number_format($totalMensualidadesActual, 2, ",", "."); ?></td>
										<td></td>
									</tr>
									<?php $contadorLineasCuotas++; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<?php
				if ($contadorLineasCuotas >= 30):
					$contadorLineasCuotas = 1 ?>
					<div class="saltopagina">
				<?php
				else: ?>		
					<div>
				<?php
				endif; ?>
					<div class="row">
						<div class="col-md-12">					
							<table>
								<thead>
									<tr>
										<th>&nbsp;</th>
									</tr>	
									<tr>
										<th style="font-size: 14px; line-height: 16px;"><b><?= 'Pago de Matrícula Próximo Año Escolar' ?></b></th>
									</tr>
								</thead>
								<?php $contadorLineasCuotas++; ?>
							</table>
						</div>
					</div>
				</div>
				<div>
					<div class="row">
						<div class="col-md-12">					
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th style="text-align: center;"><b>Nro.</b></th>
										<th style="text-align: center;"><b>Nro. Factura</b></th>
										<th style="text-align: center;"><b>Nro. Control</b></th>
										<th style="text-align: center;"><b>Cedula/Rif</b></th>
										<th style="text-align: center;"><b>Nombre o razón social</b></th>
										<th style="text-align: center;"><b>Concepto</b></th>
										<th style="text-align: center;"><b>Monto Bs.</b></th>
										<th style="text-align: center;"><b>Observación</b></th>
									</tr>
								</thead>
								<?php $contadorLineasCuotas++; ?>
								<tbody>				
									<?php $contadorMatriculaProximo = 0;
									$totalMatriculaProximo = 0; 
									$proximoAñoEscolar = $schools->current_school_year + 1;
									foreach ($soloFacturas as $factura):
										if (substr($factura->school_year, 13, 4) == $proximoAñoEscolar):
											foreach ($vectorConceptos as $concepto):
												if ($concepto['idFactura'] == $factura->id):
													if ($concepto['concepto'] == 'Matrícula '.$proximoAñoEscolar): 
														$contadorMatriculaProximo++; ?>
														<tr>
															<td style="text-align: center;"><?= $contadorMatriculaProximo; ?></td>
															<td style="text-align: center;"><?= $factura->bill_number; ?></td>
															<td style="text-align: center;"><?= $factura->control_number; ?></td>
															<td style="text-align: center;"><?= $factura->identification; ?></td>
															<td style="text-align: center;"><?= $factura->client; ?></td>
															<td style="text-align: center;"><?= $concepto['concepto']; ?></td>
															<td style="text-align: center;"><?= number_format($concepto['monto'], 2, ",", "."); ?></td>
															<td style="text-align: center;"><?= $concepto['observacion']; ?></td>
														</tr>
														<?php $contadorLineasCuotas++; ?>
														<?php $totalMatriculaProximo = $totalMatriculaProximo + $concepto['monto'];
													endif;
												endif;
											endforeach;
										endif;
									endforeach ?>
									<tr>
										<td><b>Totales</b></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td style="text-align: center;"><?= number_format($totalMatriculaProximo, 2, ",", "."); ?></td>
										<td></td>
									</tr>
									<?php $contadorLineasCuotas++; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<?php
				if ($contadorLineasCuotas >= 30):
					$contadorLineasCuotas = 1 ?>
					<div class="saltopagina">
				<?php
				else: ?>		
					<div>
				<?php
				endif; ?>
					<div class="row">
						<div class="col-md-12">					
							<table>
								<thead>
									<tr>
										<th>&nbsp;</th>
									</tr>	
									<tr>
										<th style="font-size: 14px; line-height: 16px;"><b><?= 'Pago de Mensualidades Próximo Año Escolar' ?></b></th>
									</tr>
								</thead>
								<?php $contadorLineasCuotas++; ?>
							</table>
						</div>
					</div>
				</div>
				<div>
					<div class="row">
						<div class="col-md-12">					
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th style="text-align: center;"><b>Nro.</b></th>
										<th style="text-align: center;"><b>Nro. Factura</b></th>
										<th style="text-align: center;"><b>Nro. Control</b></th>
										<th style="text-align: center;"><b>Cedula/Rif</b></th>
										<th style="text-align: center;"><b>Nombre o razón social</b></th>
										<th style="text-align: center;"><b>Concepto</b></th>
										<th style="text-align: center;"><b>Monto Bs.</b></th>
										<th style="text-align: center;"><b>Observación</b></th>
									</tr>
								</thead>
								<?php $contadorLineasCuotas++; ?>
								<tbody>				
									<?php $contadorMensualidadesProximo = 0;
									$totalMensualidadesProximo = 0;
									$proximoAñoEscolar = $schools->current_school_year + 1; 
									foreach ($soloFacturas as $factura):
										if (substr($factura->school_year, 13, 4) == $proximoAñoEscolar):
											foreach ($vectorConceptos as $concepto):
												if ($concepto['idFactura'] == $factura->id):
													if ($concepto['concepto'] != 'Matrícula '.$proximoAñoEscolar): 
														$contadorMensualidadesProximo++; ?>
														<tr>
															<td style="text-align: center;"><?= $contadorMensualidadesProximo; ?></td>
															<td style="text-align: center;"><?= $factura->bill_number; ?></td>
															<td style="text-align: center;"><?= $factura->control_number; ?></td>
															<td style="text-align: center;"><?= $factura->identification; ?></td>
															<td style="text-align: center;"><?= $factura->client; ?></td>
															<td style="text-align: center;"><?= $concepto['concepto']; ?></td>
															<td style="text-align: center;"><?= number_format($concepto['monto'], 2, ",", "."); ?></td>
															<td style="text-align: center;"><?= $concepto['observacion']; ?></td>
														</tr>
														<?php $contadorLineasCuotas++; ?>
														<?php $totalMensualidadesProximo = $totalMensualidadesProximo + $concepto['monto'];
													endif;
												endif;
											endforeach;
										endif;
									endforeach ?>
									<tr>
										<td><b>Totales</b></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td style="text-align: center;"><?= number_format($totalMensualidadesProximo, 2, ",", "."); ?></td>
										<td></td>
									</tr>
									<?php $contadorLineasCuotas++; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<?php
				if ($contadorLineasCuotas >= 30):
					$contadorLineasCuotas = 1 ?>
					<div class="saltopagina">
				<?php
				else: ?>		
					<div>
				<?php
				endif; ?>					
					<div class="row">
						<div class="col-md-12">					
							<table>
								<thead>
									<tr>
										<th>&nbsp;</th>
									</tr>	
									<tr>
										<th style="font-size: 14px; line-height: 16px;"><b><?= 'Pago de Matrícula Años Escolares Anteriores' ?></b></th>
									</tr>
								</thead>
								<?php $contadorLineasCuotas++; ?>
							</table>
						</div>
					</div>
				</div>
				<div>
					<div class="row">
						<div class="col-md-12">					
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th style="text-align: center;"><b>Nro.</b></th>
										<th style="text-align: center;"><b>Nro. Factura</b></th>
										<th style="text-align: center;"><b>Nro. Control</b></th>
										<th style="text-align: center;"><b>Cedula/Rif</b></th>
										<th style="text-align: center;"><b>Nombre o razón social</b></th>
										<th style="text-align: center;"><b>Concepto</b></th>
										<th style="text-align: center;"><b>Monto Bs.</b></th>
										<th style="text-align: center;"><b>Observación</b></th>
									</tr>
								</thead>
								<?php $contadorLineasCuotas++; ?>
								<tbody>				
									<?php $contadorMatriculaAnterior = 0;
									$totalMatriculaAnterior = 0; 
									$actualAñoEscolar = $schools->current_school_year;
									foreach ($soloFacturas as $factura):
										if (substr($factura->school_year, 13, 4) < $actualAñoEscolar):
											foreach ($vectorConceptos as $concepto):
												if ($concepto['idFactura'] == $factura->id):
													if (substr($concepto['concepto'], 0, 8) == 'Matrícul'): 
														$contadorMatriculaAnterior++; ?>
														<tr>
															<td style="text-align: center;"><?= $contadorMatriculaAnterior; ?></td>
															<td style="text-align: center;"><?= $factura->bill_number; ?></td>
															<td style="text-align: center;"><?= $factura->control_number; ?></td>
															<td style="text-align: center;"><?= $factura->identification; ?></td>
															<td style="text-align: center;"><?= $factura->client; ?></td>
															<td style="text-align: center;"><?= $concepto['concepto']; ?></td>
															<td style="text-align: center;"><?= number_format($concepto['monto'], 2, ",", "."); ?></td>
															<td style="text-align: center;"><?= $concepto['observacion']; ?></td>
														</tr>
														<?php $contadorLineasCuotas++; ?>
														<?php $totalMatriculaAnterior = $totalMatriculaAnterior + $concepto['monto'];
													endif;
												endif;
											endforeach;
										endif;
									endforeach ?>
									<tr>
										<td><b>Totales</b></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td style="text-align: center;"><?= number_format($totalMatriculaAnterior, 2, ",", "."); ?></td>
										<td></td>
									</tr>
									<?php $contadorLineasCuotas++; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<?php
				if ($contadorLineasCuotas >= 30):
					$contadorLineasCuotas = 1 ?>
					<div class="saltopagina">
				<?php
				else: ?>		
					<div>
				<?php
				endif; ?>
					<div class="row">
						<div class="col-md-12">					
							<table>
								<thead>
									<tr>
										<th>&nbsp;</th>
									</tr>	
									<tr>
										<th style="font-size: 14px; line-height: 16px;"><b><?= 'Pago de Mensualidades Años Escolares Anteriores' ?></b></th>
									</tr>
								</thead>
								<?php $contadorLineasCuotas++; ?>
							</table>
						</div>
					</div>
				</div>
				<div>
					<div class="row">
						<div class="col-md-12">					
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th style="text-align: center;"><b>Nro.</b></th>
										<th style="text-align: center;"><b>Nro. Factura</b></th>
										<th style="text-align: center;"><b>Nro. Control</b></th>
										<th style="text-align: center;"><b>Cedula/Rif</b></th>
										<th style="text-align: center;"><b>Nombre o razón social</b></th>
										<th style="text-align: center;"><b>Concepto</b></th>
										<th style="text-align: center;"><b>Monto Bs.</b></th>
										<th style="text-align: center;"><b>Observación</b></th>
									</tr>
								</thead>
								<?php $contadorLineasCuotas++; ?>
								<tbody>				
									<?php $contadorMensualidadesAnterior = 0;
									$totalMensualidadesAnterior = 0;
									$actualAñoEscolar = $schools->current_school_year; 
									foreach ($soloFacturas as $factura):
										if (substr($factura->school_year, 13, 4) < $actualAñoEscolar):
											foreach ($vectorConceptos as $concepto):
												if ($concepto['idFactura'] == $factura->id):
													if (substr($concepto['concepto'], 0, 8) != 'Matrícul'):
														$contadorMensualidadesAnterior++; ?>
														<tr>
															<td style="text-align: center;"><?= $contadorMensualidadesAnterior; ?></td>
															<td style="text-align: center;"><?= $factura->bill_number; ?></td>
															<td style="text-align: center;"><?= $factura->control_number; ?></td>
															<td style="text-align: center;"><?= $factura->identification; ?></td>
															<td style="text-align: center;"><?= $factura->client; ?></td>
															<td style="text-align: center;"><?= $concepto['concepto']; ?></td>
															<td style="text-align: center;"><?= number_format($concepto['monto'], 2, ",", "."); ?></td>
															<td style="text-align: center;"><?= $concepto['observacion']; ?></td>
														</tr>
														<?php $contadorLineasCuotas++; ?>
														<?php $totalMensualidadesAnterior = $totalMensualidadesAnterior + $concepto['monto'];
													endif;
												endif;
											endforeach;
										endif;
									endforeach ?>
									<tr>
										<td><b>Totales</b></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td style="text-align: center;"><?= number_format($totalMensualidadesAnterior, 2, ",", "."); ?></td>
										<td></td>
									</tr>
									<?php $contadorLineasCuotas++; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<?php if ($indicadorReintegros == 1): ?>
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table>
									<thead>
										<tr>
											<th>&nbsp;</th>
										</tr>	
										<tr>
											<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE REINTEGROS:</b></th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th style="text-align: center;"><b>Familia</b></th>
											<th style="text-align: center;"><b>No Recibo</b></th>
											<th style="text-align: center;"><b>Tipo doc</b></th>
											<th style="text-align: center;"><b>Monto $</b></th>
											<th style="text-align: center;"><b>Monto €</b></th>
											<th style="text-align: center;"><b>Monto Bs.</b></th>
										</tr>
									</thead>
									<tbody>				
										<?php $totalDolar = 0;
										$totalEuro = 0;
										$totalBolivar = 0;
										foreach ($facturas as $factura):  
											if ($factura->tipo_documento == "Recibo de reintegro"): ?> 
												<tr>
													<td><?= $factura->parentsandguardian->family ?></td>
													<td style="text-align: center;"><?= $factura->bill_number ?></td>
													<td><?= $factura->tipo_documento ?></td>
													<?php if ($factura->moneda_id == 1):
														$totalBolivar += $factura->amount_paid; ?>
														<td></td><td></td><td style="text-align: center;"><?= number_format($factura->amount_paid, 2, ",", ".") ?></td>
													<?php elseif ($factura->moneda_id == 2):
														$totalDolar += $factura->amount_paid; ?>
														<td style="text-align: center;"><?= number_format($factura->amount_paid, 2, ",", ".") ?></td><td></td><td></td>
													<?php else:
														$totalEuro += $factura->amount_paid; ?>
														<td></td><td style="text-align: center;"><?= number_format($factura->amount_paid, 2, ",", ".") ?></td><td></td>
													<?php endif; ?>
												</tr>
											<?php endif;
										endforeach; ?>
										<tr>
											<td><b>Totales</b></td>
											<td></td>
											<td></td>
											<td style="text-align: center;"><b><?= number_format($totalDolar, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalEuro, 2, ",", ".") ?></b></td>											
											<td style="text-align: center;"><b><?= number_format($totalBolivar, 2, ",", ".") ?></b></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<?php if ($indicadorCompras == 1): ?>
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table>
									<thead>
										<tr>
											<th>&nbsp;</th>
										</tr>	
										<tr>
											<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE COMPRAS:</b></th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th style="text-align: center;"><b>Familia</b></th>
											<th style="text-align: center;"><b>No Recibo</b></th>
											<th style="text-align: center;"><b>Tipo doc</b></th>
											<th style="text-align: center;"><b>Monto $</b></th>
											<th style="text-align: center;"><b>Monto €</b></th>
											<th style="text-align: center;"><b>Monto Bs.</b></th>
										</tr>
									</thead>
									<tbody>				
										<?php $totalDolar = 0;
										$totalEuro = 0;
										$totalBolivar = 0;
										foreach ($facturas as $factura):  
											if ($factura->tipo_documento == "Recibo de compra"): ?> 
												<tr>
													<td><?= $factura->parentsandguardian->family ?></td>
													<td style="text-align: center;"><?= $factura->bill_number ?></td>
													<td><?= $factura->tipo_documento ?></td>
													<?php if ($factura->moneda_id == 1):
														$totalBolivar += $factura->amount_paid; ?>
														<td></td><td></td><td style="text-align: center;"><?= number_format($factura->amount_paid, 2, ",", ".") ?></td>
													<?php elseif ($factura->moneda_id == 2):
														$totalDolar += $factura->amount_paid; ?>
														<td style="text-align: center;"><?= number_format($factura->amount_paid, 2, ",", ".") ?></td><td></td><td></td>
													<?php else:
														$totalEuro += $factura->amount_paid; ?>
														<td></td><td style="text-align: center;"><?= number_format($factura->amount_paid, 2, ",", ".") ?></td><td></td>
													<?php endif; ?>
												</tr>
											<?php endif;
										endforeach; ?>
										<tr>
											<td><b>Totales</b></td>
											<td></td>
											<td></td>
											<td style="text-align: center;"><b><?= number_format($totalDolar, 2, ",", ".") ?></b></td>
											<td style="text-align: center;"><b><?= number_format($totalEuro, 2, ",", ".") ?></b></td>											
											<td style="text-align: center;"><b><?= number_format($totalBolivar, 2, ",", ".") ?></b></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<?php if ($indicadorNotasCredito == 1): ?>
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table>
									<thead>
										<tr>
											<th>&nbsp;</th>
										</tr>	
										<tr>
											<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE NOTAS DE CRÉDITO:</b></th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th style="text-align: center;"><b>Familia</b></th>
											<th style="text-align: center;"><b>Control</b></th>
											<th style="text-align: center;"><b>Factura</b></th>
											<th style="text-align: center;"><b>Tipo doc</b></th>
											<th style="text-align: center;"><b>Monto Bs.</b></th>
										</tr>
									</thead>
									<tbody>				
										<?php $totalBolivar = 0;
										foreach ($facturas as $factura):  
											if ($factura->tipo_documento == "Nota de crédito"): ?> 
												<tr>
													<td><?= $factura->parentsandguardian->family ?></td>
													<td style="text-align: center;"><?= $factura->control_number ?></td>
													<td style="text-align: center;"><?= $factura->bill_number ?></td>
													<td><?= $factura->tipo_documento ?></td>
													<?php $totalBolivar += $factura->amount_paid; ?>
													<td style="text-align: center;"><?= number_format($factura->amount_paid, 2, ",", ".") ?></td>
												</tr>
											<?php endif;
										endforeach; ?>
										<tr>
											<td><b>Totales</b></td>
											<td></td>
											<td></td>
											<td></td>
											<td style="text-align: center;"><b><?= number_format($totalBolivar, 2, ",", ".") ?></b></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<?php if ($indicadorNotasDebito == 1): ?>
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table>
									<thead>
										<tr>
											<th>&nbsp;</th>
										</tr>	
										<tr>
											<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE NOTAS DE DÉBITO:</b></th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th style="text-align: center;"><b>Familia</b></th>
											<th style="text-align: center;"><b>Control</b></th>
											<th style="text-align: center;"><b>Factura</b></th>
											<th style="text-align: center;"><b>Tipo doc</b></th>
											<th style="text-align: center;"><b>Monto Bs.</b></th>
										</tr>
									</thead>
									<tbody>				
										<?php $totalBolivar = 0;
										foreach ($facturas as $factura):  
											if ($factura->tipo_documento == "Nota de débito"): ?>
												<tr>
													<td><?= $factura->parentsandguardian->family ?></td>
													<td style="text-align: center;"><?= $factura->control_number ?></td>
													<td style="text-align: center;"><?= $factura->bill_number ?></td>
													<td><?= $factura->tipo_documento ?></td>
													<?php $totalBolivar += $factura->amount_paid; ?>
													<td style="text-align: center;"><?= number_format($factura->amount_paid, 2, ",", ".") ?></td>
												</tr>
											<?php endif;
										endforeach; ?>
										<tr>
											<td><b>Totales</b></td>
											<td></td>
											<td></td>
											<td></td>
											<td style="text-align: center;"><b><?= number_format($totalBolivar, 2, ",", ".") ?></b></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<?php if ($indicadorFacturasRecibos == 1): ?>
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table>
									<thead>
										<tr>
											<th>&nbsp;</th>
										</tr>	
										<tr>
											<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE FACTURAS CORRESPONDIENTES A ANTICIPOS:</b></th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th style="text-align: center;"><b>Familia</b></th>
											<th style="text-align: center;"><b>Control</b></th>
											<th style="text-align: center;"><b>Factura</b></th>
											<th style="text-align: center;"><b>Tipo doc</b></th>
											<th style="text-align: center;"><b>Monto Bs.</b></th>
										</tr>
									</thead>
									<tbody>				
										<?php $totalBolivar = 0;
										foreach ($facturas as $factura):  
											if ($factura->id_anticipo > 0): ?>
												<tr>
													<td><?= $factura->parentsandguardian->family ?></td>
													<td style="text-align: center;"><?= $factura->control_number ?></td>
													<td style="text-align: center;"><?= $factura->bill_number ?></td>
													<td><?= $factura->tipo_documento ?></td>
													<?php $totalBolivar += $factura->amount_paid; ?>
													<td style="text-align: center;"><?= number_format($factura->amount_paid, 2, ",", ".") ?></td>
												</tr>
											<?php endif;
										endforeach; ?>
										<tr>
											<td><b>Totales</b></td>
											<td></td>
											<td></td>
											<td></td>
											<td style="text-align: center;"><b><?= number_format($totalBolivar, 2, ",", ".") ?></b></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<?php if ($indicadorSobrantes == 1): ?>
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table>
									<thead>
										<tr>
											<th>&nbsp;</th>
										</tr>	
										<tr>
											<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE SOBRANTES (VUELTOS PENDIENTES POR ENTREGAR):</b></th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th style="text-align: center;"><b>Familia</b></th>
											<th style="text-align: center;"><b>Recibo</b></th>
											<th style="text-align: center;"><b>Tipo doc</b></th>
											<th style="text-align: center;"><b>Monto $.</b></th>
										</tr>
									</thead>
									<tbody>				
										<?php foreach ($facturas as $factura):  
											if ($factura->tipo_documento == "Recibo de sobrante"): ?>
												<tr>
													<td><?= $factura->parentsandguardian->family ?></td>
													<td style="text-align: center;"><?= $factura->control_number ?></td>
													<td><?= $factura->tipo_documento ?></td>
													<td style="text-align: center;"><?= number_format($factura->amount_paid, 2, ",", ".") ?></td>
												</tr>
											<?php endif;
										endforeach; ?>
										<tr>
											<td><b>Totales</b></td>
											<td></td>
											<td></td>
											<td style="text-align: center;"><b><?= number_format($totalGeneralSobrantes, 2, ",", ".") ?></b></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<?php if ($indicadorFacturasAnuladas == 1): ?>
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table>
									<thead>
										<tr>
											<th>&nbsp;</th>
										</tr>	
										<tr>
											<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE FACTURAS ANULADAS:</b></th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th style="text-align: center;"><b>Control</b></th>
											<th style="text-align: center;"><b>Factura</b></th>
											<th style="text-align: center;"><b>Tipo doc</b></th>
										</tr>
									</thead>
									<tbody>				
										<?php $totalBolivar = 0;
										foreach ($documentosAnulados as $anulado):  
											if ($anulado->fiscal == 1): ?> 
												<tr>
													<td style="text-align: center;"><?= $anulado->control_number ?></td>
													<td style="text-align: center;"><?= $anulado->bill_number ?></td>
													<td style="text-align: center;"><?= $anulado->tipo_documento ?></td>
												</tr>
											<?php endif;
										endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<?php if ($indicadorRecibosAnulados == 1): ?>
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table>
									<thead>
										<tr>
											<th>&nbsp;</th>
										</tr>	
										<tr>
											<th style="font-size: 14px; line-height: 16px;"><b>DETALLE DE RECIBOS ANULADOS:</b></th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
					<div>
						<div class="row">
							<div class="col-md-12">					
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th style="text-align: center;"><b>Recibo</b></th>
											<th style="text-align: center;"><b>Tipo doc</b></th>
										</tr>
									</thead>
									<tbody>				
										<?php $totalBolivar = 0;
										foreach ($documentosAnulados as $anulado):  
											if ($anulado->fiscal == 0): ?> 
												<tr>
													<td style="text-align: center;"><?= $anulado->control_number ?></td>
													<td style="text-align: center;"><?= $anulado->tipo_documento ?></td>
												</tr>
											<?php endif;
										endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		
			<div>
				<div class="row">
					<div class="col-md-12">					
						<table>
							<thead>
								<tr>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
								</tr>
								<tr>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
								</tr>
								<tr>
									<th>&nbsp;</th>
									<th>Entregado por:</th>
									<th>______________________________</th>
									<th>&nbsp;</th>
									<th>Recibido por:</th>
									<th>______________________________</th>
								</tr>
								<tr>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
						</table>
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
			
			$("#reporte-cierre").table2excel({
		
				exclude: ".noExl",
			
				name: "reporte_cierre",
			
				filename: $('#reporte-cierre').attr('name') 
		
			});
		});
    });
        
</script>