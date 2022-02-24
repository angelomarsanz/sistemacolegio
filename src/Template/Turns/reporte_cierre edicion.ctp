				<div class="saltopagina">
					<div class="row">
						<div class="col-md-12">					
							<table>
								<thead>
									<tr>
										<th>&nbsp;</th>
									</tr>	
									<tr>
										<th style="font-size: 14px; line-height: 16px;"><b><?= 'Pago de Matrícula Años Anteriores' ?></b></th>
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
								<tbody>				
									<?php $contadorMatriculaAnterior = 0;
									$totalMatriculaAnterior = 0; 
									$actualAñoEscolar = $schools->current_shools_year;
									foreach ($soloFacturas as $factura):
										if (substr($factura->school_year, 12, 4) < $actualAñoEscolar):
											foreach ($vectorConceptos as $concepto):
												if ($concepto['idFactura'] == $factura->id):
													if (substr($concepto['concepto'], 0, 8) == 'Matrícula'): 
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
										<th style="font-size: 14px; line-height: 16px;"><b><?= 'Pago de Mensualidades Años Anteriores' ?></b></th>
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
								<tbody>				
									<?php $contadorMensualidadesAnterior = 0;
									$totalMensualidadesAnterior = 0;
									$actualAñoEscolar = $schools->current_shools_year; 
									foreach ($soloFacturas as $factura):
										if (substr($factura->school_year, 12, 4) < $actualAñoEscolar):
											foreach ($vectorConceptos as $concepto):
												if ($concepto['idFactura'] == $factura->id):
													if (substr($concepto['concepto'], 0, 8) != 'Matrícula'):
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
								</tbody>
							</table>
						</div>
					</div>
				</div>
