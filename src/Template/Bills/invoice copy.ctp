<?php

use Cake\I18n\Time;

setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
date_default_timezone_set('America/Caracas');
        
$tiempoActual = Time::now();
?>
<style>
@media screen
{
    .alignRight
    {
    	text-align: right;
    }
    hr
    {
    	color: #47476b;
		height: 1px;
		background-color: black;
		margin: 5px 0px 5px 0px;
    }
    #payments
    {
    	width: 70%;
    	float: left;
    }
    #total
    {
    	width: 30%;
    	float: left;
    }
    #emptyColumn
    {
    	width: 40%;
    	float: left;
    }
	.saltopagina
    {
        display:block;
        page-break-before:always;
    }
	body
	{
		font-family: "Calibri", "Times New Roman", Times, serif;
	}
}
@media print
{
    .alignRight
    {
    	text-align: right;
    }
    hr
    {
    	color: #47476b;
		height: 1px;
		background-color: black;
		margin: 5px 0px 5px 0px;
    }
    #payments
    {
    	width: 70%;
    	float: left;
    }
    #total
    {
    	width: 30%;
    	float: left;
    }
	#emptyColumn
    {
    	width: 40%;
    	float: left;
    }
    .saltopagina
    {
        display:block;
        page-break-before:always;
    }
    .nover 
    {
      display:none
    }
	body
	{
		font-family: "Calibri", "Times New Roman", Times, serif;
	}
}
</style>
<?php
	// Eliminar después de la migración
	$montoCompensado = 0;
	if ($bill->saldo_compensado_dolar > 0)
	{
		$montoCompensado = round($bill->saldo_compensado_dolar * $bill->tasa_cambio, 2);
	}
	// Eliminar después de la migración
?>
<?php if ($accountService == 0): ?>
	<?php if ($bill->fiscal == 1): ?>
		<br />
		<br />
		<div>
			<table style="width:100%">
				<tbody>
					<tr>					
						<?php if ($bill->tipo_documento == "Nota de crédito"): ?>
							<td style="width:30%;"><b>Nota de crédito Nro. <?= $bill->bill_number ?> <?= $facturaAfectada = $numeroFacturaAfectada > 0 ? " Factura afectada: Nro. " . $numeroFacturaAfectada . " Control " . $controlFacturaAfectada : ''; ?></td>
						<?php elseif ($bill->tipo_documento == "Nota de débito"): ?>
							<td style="width:30%;"><b>Nota de débito Nro. <?= $bill->bill_number ?></b></td>
						<?php else: ?>
							<td style="width:30%;"><b>Factura Nro. 1 - <?= $bill->bill_number ?></b></td>
						<?php endif; ?>
						<td style="width:30%;"><?= $bill->school_year ?></td>
						<td style="width:40%;"></td>
					</tr>			
					</tr>
						<td style='width:30%;'>C.I./RIF: <?= $bill->identification ?></td>
						<td style='width:30%;'>Teléfono: <?= $bill->tax_phone ?></td>
						<td style="width:40%; text-align: left; ">Fecha: <?= $bill->created->format('d-m-Y H:i') ?></td>
					</tr>
				</tbody>
			</table>
			<table style="width:100%;">
				<tbody>
					<tr>
						<td>Nombre o razón social: <?= $bill->client ?></td>
					</tr>
					<tr>
						<td>Dirección: <?= $bill->fiscal_address ?><td>
					</tr>
				<tbody>
			</table>
		</div>
		<hr>
		<div>
			<table style="width:100%;">
				<thead>
					<tr>
						<th style="width:10%; text-align:left;">Cantidad</th>
						<th style="width:70%; text-align:left;">Descripción</th>
						<th style="width:20%; text-align:right;">Precio Bs.</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$counter = 0;
					foreach ($vConcepts as $vConcept): ?>
						<tr>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1</td>
							<td><?= h($vConcept['invoiceLine']) ?></td>
							<td style="text-align: right;"><?= number_format($vConcept['amountConcept'], 2, ",", ".") ?></td>
						</tr>

					<?php
					$counter++;
					endforeach; ?>
				</tbody>
			</table>
		</div>
		<hr>
		<div>
			<div id="payments">
				Formas de pago:
				<table style="width:100%;">
					<tbody>
						<?php foreach ($aPayments as $aPayment): ?>
							<tr>
								<td>
									<?php if ($aPayment->banco_receptor == 'Zelle' || $aPayment->banco_receptor == 'Euros' || $aPayment->banco_receptor == 'Comprobante'): ?>
										Comprobante
									<?php else: ?>
										<?= $aPayment->payment_type ?>
									<?php endif; ?>
								</td>
								<td>&nbsp;&nbsp;&nbsp;</td>
								<td>
									<?php if ($aPayment->banco_receptor == 'Zelle' || $aPayment->banco_receptor == 'Euros' || $aPayment->banco_receptor == 'Comprobante'): ?>
										&nbsp;	
									<?php else: ?>
										<?= h($aPayment->banco_receptor) ?>
									<?php endif; ?>									
								</td>
								<td>&nbsp;&nbsp;&nbsp;</td>
								<td><?= h($aPayment->serial) ?></td>
								<td>&nbsp;&nbsp;&nbsp;</td>
								<td><?= h($aPayment->moneda) . ' ' . number_format($aPayment->amount, 2, ",", ".") ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div id="total">
				<table style="width:100%;">
					<tr>
						<td style="width: 50%;">Sub-total:</td>
						<!-- <td style="width: 50%; text-align:right;"><?= number_format(($bill->amount_paid), 2, ",", ".") ?></td> -->
						<!-- Eliminar después de la migración -->
						<td style="width: 50%; text-align:right;"><?= number_format(($bill->amount_paid - $montoCompensado), 2, ",", ".") ?></td>
						<!-- Eliminar después de la migración -->
					</tr>
					<tr>
						<td style="width: 50%;">Descuento/Recargo:</td>
						<td style="width: 50%; text-align:right;"><?= number_format(($bill->amount), 2, ",", ".") ?></td>
					</tr>
					<tr>
						<td style="width: 50%;">IVA 0%:</td>
						<td style="width: 50%;"></td>
					</tr>
					<tr>
						<td style="width: 50%;"><b>Total Bs.:</b></td>
						<!-- <td style="width: 50%; text-align:right;"><b><?= number_format($bill->amount_paid + $bill->amount, 2, ",", ".") ?></b></td> -->
						<!-- Eliminar después de la migración -->
							<td style="width: 50%; text-align:right;"><b><?= number_format($bill->amount_paid + $bill->amount - $montoCompensado, 2, ",", ".") ?></b></td>
						<!-- Eliminar después de la migración -->
					</tr>
				</table>
			</div>
		</div>
		<div style="width:70%">
			<div id="otros-datos">
				<p>
					Tasa cambio BCV <?= number_format(($bill->tasa_cambio), 2, ",", ".") ?> &nbsp;&nbsp;Cajero: <?= $usuarioResponsable ?>	&nbsp;&nbsp;Firma autorizada: 
				</p>
			</div>
		</div>
	<?php elseif ($indicadorAnticipo == 1): ?>
		<div>
			<h3>FUNDACIÓN U.E. COLEGIO VERDAD Y LIBERTAD</h3>
			<h4>RIF J-30649093-0</h4>
			<h5>Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></h5>
			<h2 style="text-align: center;">Recibo de anticipo Nro. <?= $bill->bill_number ?> por Bs. <?= number_format($bill->amount_paid, 2, ",", ".") ?></h2>
			<br />
			<p style="text-align: justify;">Hemos recibido de: <?= $bill->client ?> portador de la cédula/pasaporte/RIF <?= $bill->identification ?> la cantidad de Bs. <b><?= number_format($bill->amount_paid, 2, ",", ".") ?></b>
			como anticipo de:</p>
			<div>
				<table style="width:100%; font-size: 13px; line-height: 15px;">
					<thead>
						<tr>
							<th style="width:10%; text-align:left;">Código</th>
							<th style="width:70%; text-align:left;">Descripción</th>
							<th style="width:20%; text-align:right;">Precio Bs.</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($vConcepts as $vConcept): ?>
							<tr>
								<td><?= h($vConcept['accountingCode']) ?></td>
								<td><?= h($vConcept['invoiceLine']) ?></td>
								<td style="text-align: right;"><?= number_format($vConcept['amountConcept'], 2, ",", ".") ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<hr>
			<div style="width:100%;">
				<div id="payments" style="font-size: 10px;  line-height: 12px;">
					<b>Formas de pago:</b>
					<table style="width:100%;">
						<tbody class="nover">
							<?php foreach ($aPayments as $aPayment): ?>
								<tr>
									<td><?= h($aPayment->payment_type) ?></td>
									<td>&nbsp;&nbsp;&nbsp;</td>
									<td><?= h($aPayment->bank) ?></td>
									<td>&nbsp;&nbsp;&nbsp;</td>
									<td><?= h($aPayment->bancoReceptor) ?></td>
									<td>&nbsp;&nbsp;&nbsp;</td>
									<td><?= h($aPayment->account_or_card) ?></td>
									<td>&nbsp;&nbsp;&nbsp;</td>
									<td><?= h($aPayment->serial) ?></td>
									<td>&nbsp;&nbsp;&nbsp;</td>
									<td><?= h($aPayment->moneda) ?></td>
									<td>&nbsp;&nbsp;&nbsp;</td>
									<td><?= number_format($aPayment->amount, 2, ",", ".") ?></td>
									<td>&nbsp;&nbsp;&nbsp;</td>
									<td><?= $aPayment->comentario ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<div id="emptyColumn" style="font-size: 10px;  line-height: 12px;">
					<p>Cajero: <?= $usuarioResponsable ?></p>
				</div>
				<div id="total" style="font-size: 13px; line-height: 15px;">
					<table style="width:100%;">
						<tr>
							<td style="width: 50%;"><b>Sub-total:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount_paid), 2, ",", ".") ?></b></td>
						</tr>
						<tr>
							<td style="width: 50%;"><b>Descuento/Recargo:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount), 2, ",", ".") ?></b></td>
						</tr>
						<tr>
							<td style="width: 50%;"><b>Total Bs.:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format($bill->amount_paid + $bill->amount, 2, ",", ".") ?></b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>	
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<div>
			<h3>FUNDACIÓN U.E. COLEGIO VERDAD Y LIBERTAD</h3>
			<h4>RIF J-30649093-0</h4>
			<h5>Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></h5>
			<h2 style="text-align: center;">Recibo de anticipo Nro. <?= $bill->bill_number ?> por Bs. <?= number_format($bill->amount_paid, 2, ",", ".") ?></h2>
			<br />
			<p style="text-align: justify;">Hemos recibido de: <?= $bill->client ?> portador de la cédula/pasaporte/RIF <?= $bill->identification ?> la cantidad de Bs. <b><?= number_format($bill->amount_paid, 2, ",", ".") ?></b>
			como anticipo de:</p>
			<div>
				<table style="width:100%; font-size: 13px; line-height: 15px;">
					<thead>
						<tr>
							<th style="width:10%; text-align:left;">Código</th>
							<th style="width:70%; text-align:left;">Descripción</th>
							<th style="width:20%; text-align:right;">Precio Bs.</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($vConcepts as $vConcept): ?>
							<tr>
								<td><?= h($vConcept['accountingCode']) ?></td>
								<td><?= h($vConcept['invoiceLine']) ?></td>
								<td style="text-align: right;"><?= number_format($vConcept['amountConcept'], 2, ",", ".") ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<hr>
			<div style="width:100%;">
				<div id="payments" style="font-size: 10px;  line-height: 12px;">
					<b>Formas de pago:</b>
					<table style="width:100%;">
						<tbody class="nover">
							<?php foreach ($aPayments as $aPayment): ?>
								<tr>
									<td><?= h($aPayment->payment_type) ?></td>
									<td><?= h($aPayment->bank) ?></td>
									<td><?= h($aPayment->bancoReceptor) ?></td>
									<td><?= h($aPayment->account_or_card) ?></td>
									<td><?= h($aPayment->serial) ?></td>
									<td><?= h($aPayment->moneda) ?></td>
									<td><?= number_format($aPayment->amount, 2, ",", ".") ?></td>
									<td><?= $aPayment->comentario ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<div id="emptyColumn" style="font-size: 10px;  line-height: 12px;">
					<p>Cajero: <?= $usuarioResponsable ?></p>
				</div>
				<div id="total" style="font-size: 13px; line-height: 15px;">
					<table style="width:100%;">
						<tr>
							<td style="width: 50%;"><b>Sub-total:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount_paid), 2, ",", ".") ?></b></td>
						</tr>
						<tr>
							<td style="width: 50%;"><b>Descuento/Recargo:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount), 2, ",", ".") ?></b></td>
						</tr>
						<tr>
							<td style="width: 50%;"><b>Total Bs.:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format($bill->amount_paid + $bill->amount, 2, ",", ".") ?></b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php else: ?>
	<?php if ($indicadorAnticipo == 1): ?>
		<div>
			<h3>FUNDACIÓN U.E. COLEGIO VERDAD Y LIBERTAD</h3>
			<h4>RIF J-30649093-0</h4>
			<h5>Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></h5>
			<h2 style="text-align: center;">Recibo de anticipo Nro. <?= $bill->bill_number ?> por Bs. <?= number_format(($bill->amount_paid - $accountService), 2, ",", ".") ?></h2>
			<br />
			<p style="text-align: justify;">Hemos recibido de: <?= $bill->client ?> portador de la cédula/pasaporte/RIF <?= $bill->identification ?> la cantidad de Bs. <b><?= number_format($bill->amount_paid, 2, ",", ".") ?></b>
			como anticipo de:</p>
			<div>
				<table style="width:100%; font-size: 13px; line-height: 15px;">
					<thead>
						<tr>
							<th style="width:10%; text-align:left;">Código</th>
							<th style="width:70%; text-align:left;">Descripción</th>
							<th style="width:20%; text-align:right;">Precio Bs.</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($vConcepts as $vConcept): ?>
							<tr>
								<td><?= h($vConcept['accountingCode']) ?></td>
								<td><?= h($vConcept['invoiceLine']) ?></td>
								<td style="text-align: right;"><?= number_format($vConcept['amountConcept'], 2, ",", ".") ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<hr>
			<div style="width:100%;">
				<div id="payments" style="font-size: 10px;  line-height: 12px;">
					<b>Formas de pago:</b>
					<table style="width:100%;">
						<tbody class="nover">
							<?php foreach ($aPayments as $aPayment): ?>
								<tr>
									<td><?= h($aPayment->payment_type) ?></td>
									<td><?= h($aPayment->bank) ?></td>
									<td><?= h($aPayment->bancoReceptor) ?></td>
									<td><?= h($aPayment->account_or_card) ?></td>
									<td><?= h($aPayment->serial) ?></td>
									<td><?= h($aPayment->moneda) ?></td>
									<td><?= number_format($aPayment->amount, 2, ",", ".") ?></td>
									<td><?= $aPayment->comentario ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<div id="emptyColumn" style="font-size: 10px;  line-height: 12px;">
					<p>Cajero: <?= $usuarioResponsable ?></p>
				</div>
				<div id="total" style="font-size: 13px; line-height: 15px;">
					<table style="width:100%;">
						<tr>
							<td style="width: 50%;"><b>Sub-total:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount_paid - $accountService), 2, ",", ".") ?></b></td>
						</tr>
						<tr>
							<td style="width: 50%;"><b>Descuento/Recargo:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount), 2, ",", ".") ?></b></td>
						</tr>
						<tr>
							<td style="width: 50%;"><b>Total Bs.:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount_paid + $bill->amount - $accountService), 2, ",", ".") ?></b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>	
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<div>
			<h3>FUNDACIÓN U.E. COLEGIO VERDAD Y LIBERTAD</h3>
			<h4>RIF J-30649093-0</h4>
			<h5>Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></h5>
			<h2 style="text-align: center;">Recibo de anticipo Nro. <?= $bill->bill_number ?> por Bs. <?= number_format(($bill->amount_paid - $accountService), 2, ",", ".") ?></h2>
			<br />
			<p style="text-align: justify;">Hemos recibido de: <?= $bill->client ?> portador de la cédula/pasaporte/RIF <?= $bill->identification ?> la cantidad de Bs. <b><?= number_format($bill->amount_paid, 2, ",", ".") ?></b>
			como anticipo de:</p>
			<div>
				<table style="width:100%; font-size: 13px; line-height: 15px;">
					<thead>
						<tr>
							<th style="width:10%; text-align:left;">Código</th>
							<th style="width:70%; text-align:left;">Descripción</th>
							<th style="width:20%; text-align:right;">Precio Bs.</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($vConcepts as $vConcept): ?>
							<tr>
								<td><?= h($vConcept['accountingCode']) ?></td>
								<td><?= h($vConcept['invoiceLine']) ?></td>
								<td style="text-align: right;"><?= number_format($vConcept['amountConcept'], 2, ",", ".") ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<hr>
			<div style="width:100%;">
				<div id="payments" style="font-size: 10px;  line-height: 12px;">
					<b>Formas de pago:</b>
					<table style="width:100%;">
						<tbody class="nover">
							<?php foreach ($aPayments as $aPayment): ?>
								<tr>
									<td><?= h($aPayment->payment_type) ?></td>
									<td><?= h($aPayment->bank) ?></td>
									<td><?= h($aPayment->bancoReceptor) ?></td>
									<td><?= h($aPayment->account_or_card) ?></td>
									<td><?= h($aPayment->serial) ?></td>
									<td><?= h($aPayment->moneda) ?></td>
									<td><?= number_format($aPayment->amount, 2, ",", ".") ?></td>
									<td><?= $aPayment->comentario ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<div id="emptyColumn" style="font-size: 10px;  line-height: 12px;">
					<p>Cajero: <?= $usuarioResponsable ?></p>
				</div>
				<div id="total" style="font-size: 13px; line-height: 15px;">
					<table style="width:100%;">
						<tr>
							<td style="width: 50%;"><b>Sub-total:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount_paid - $accountService), 2, ",", ".") ?></b></td>
						</tr>
						<tr>
							<td style="width: 50%;"><b>Descuento/Recargo:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount), 2, ",", ".") ?></b></td>
						</tr>
						<tr>
							<td style="width: 50%;"><b>Total Bs.:</b></td>
							<td style="width: 50%; text-align:right;"><b><?= number_format(($bill->amount_paid + $bill->amount - $accountService), 2, ",", ".") ?></b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<br />
		<br />
		<br />
		<br />
		<div class="saltopagina">
			<h5>Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></h5>
			<h3 style="text-align: right;">Recibo de Servicio Educativo Nro. <?= $bill->bill_number . '-2' ?></h3>
	<?php else: ?>
		<div>
			<h5>Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></h5>
			<h3 style="text-align: right;">Recibo de Servicio Educativo Nro. <?= $bill->bill_number ?></h3>		
	<?php endif; ?>	
		<h2 style="text-align: center;">Por Bs. <?= number_format($accountService + $bill->amount, 2, ",", ".") ?>  (<?= number_format(($accountService + $bill->amount_dollar)/$bill->tasa_cambio, 2, ",", ".") ?>  $)</h2>
		<br />
		<p style="text-align: justify;">Hemos recibido de: <?= $bill->client ?> portador de la cédula/pasaporte/RIF <?= $bill->identification ?> la cantidad de Bs. <b><?= number_format($accountService, 2, ",", ".") ?></b>
		por concepto de servicio educativo, correspondiente a lo(s) alumno(s):</p>
		<table style="width:100%;">
			<tbody>
				<?php foreach ($studentReceipt as $studentReceipts): ?>
						<tr>
							<td>&nbsp;&nbsp;&nbsp;- <?= h($studentReceipts['studentName']) ?></td>
						</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<br />
		<br />
		<div id="payments">
			Formas de pago:
			<table style="width:100%;">
				<tbody class="nover">
					<?php foreach ($aPayments as $aPayment): ?>
						<tr>
							<td><?= h($aPayment->payment_type) ?></td>
							<td><?= h($aPayment->bank) ?></td>
							<td><?= h($aPayment->bancoReceptor) ?></td>
							<td><?= h($aPayment->account_or_card) ?></td>
							<td><?= h($aPayment->serial) ?></td>
							<td><?= h($aPayment->moneda) ?></td>
							<td><?= number_format($aPayment->amount, 2, ",", ".") ?></td>
							<td><?= $aPayment->comentario ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<br />
		<br />
		<br />
	</div>
<?php endif; ?>
<?php if ($indicadorSobrante == 1): ?>
	<br />
	<br />
	<div>
		<h3>FUNDACIÓN U.E. COLEGIO VERDAD Y LIBERTAD</h3>
		<h4>RIF J-30649093-0</h4>
		<h5>Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></h5>
		<h2 style="text-align: center;">Recibo de sobrante Nro. <?= $bill->bill_number ?> por $ <?= number_format($bill->amount_paid, 2, ",", ".") ?></h2>
		<br />
		<p style="text-align: justify;">Hemos recibido de: <?= $bill->client ?> portador de la cédula/pasaporte/RIF <?= $bill->identification ?> la cantidad de $ <b><?= number_format($bill->amount_paid, 2, ",", ".") ?></b>
		como abono para pagar futuras cuotas.</p>
	</div>
<?php endif; ?>
<?php if ($indicadorReintegro == 1): ?>
	<br />
	<br />
	<div>
		<h3>FUNDACIÓN U.E. COLEGIO VERDAD Y LIBERTAD</h3>
		<h4>RIF J-30649093-0</h4>
		<h5>Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></h5>
		<h2 style="text-align: center;">Recibo de Reintegro Nro. <?= $bill->bill_number ?> por $ <?= number_format($bill->amount_paid, 2, ",", ".") ?></h2>
		<br />
		<p style="text-align: justify;">Hemos recibido del colegio San Gabriel Arcángel, C.A. la cantidad de $ <b><?= number_format($bill->amount_paid, 2, ",", ".") ?></b> por concepto de reintegro.</p>
		<br />
		<p><?= $bill->client ?></p>
		<p><?= $bill->identification ?></p>
		<p>Firma</p>
	</div>
<?php endif; ?>
<?php if ($indicadorCompra == 1): ?>
	<br />
	<br />
	<div>
		<h3>FUNDACIÓN U.E. COLEGIO VERDAD Y LIBERTAD</h3>
		<h4>RIF J-30649093-0</h4>
		<h5>Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></h5>
		<h2 style="text-align: center;">Recibo de Compra Nro. <?= $bill->bill_number ?> por <?= $monedaDocumento . ' ' . number_format($bill->amount_paid, 2, ",", ".") ?></h2>
		<br />
		<p style="text-align: justify;">Por concepto de: </p>
			
		<?php foreach ($vConcepts as $vConcept): ?>
			<?= h($vConcept['invoiceLine']) ?><br />
		<?php endforeach; ?>
	</div>
<?php endif; ?>
<?php if ($indicadorVueltoCompra == 1): ?>
	<br />
	<br />
	<div>
		<h3>FUNDACIÓN U.E. COLEGIO VERDAD Y LIBERTAD</h3>
		<h4>RIF J-30649093-0</h4>
		<h5>Fecha: <?= $bill->date_and_time->format('d-m-Y') ?></h5>
		<h2 style="text-align: center;">Recibo de Vuelto de Compra Nro. <?= $bill->bill_number ?> por <?= $monedaDocumento . ' ' . number_format($bill->amount_paid, 2, ",", ".") ?></h2>
		<br />
		<p style="text-align: justify;">Por concepto de: </p>
			
		<?php foreach ($vConcepts as $vConcept): ?>
			<?= h($vConcept['invoiceLine']) ?><br />
		<?php endforeach; ?>
	</div>
<?php endif; ?>
<button class='nover btn btn-success' onclick='imprimirPantalla()'>Imprimir</button>
<script>
    $(document).ready(function()
    {
		mensajeUsuario ="<?= $mensajeUsuario ?>";
		if (mensajeUsuario != "")
		{
			alert(mensajeUsuario);
		}
	});
</script>