<h1>testFunction</h1>
<br />
<h3>Meses Tarifas</p>
<br />
<?php
foreach ($mesesTarifas as $tarifa)
{
?>
    <p><?= $tarifa['anoMes'] . ' - ' . number_format($tarifa['tarifaDolar'], 2, ",", ".") . ' - ' . number_format($tarifa['tarifaBolivar'], 2, ",", ".") ?><p>
<?php
}
?>
<br />
<h3>Otras Tarifas</p>
<br />
<?php
foreach ($otrasTarifas as $tarifa)
{
?>
    <p><?= $tarifa['conceptoAno'] . ' - ' . number_format($tarifa['tarifaDolar'], 2, ",", ".") . ' - ' . number_format($tarifa['tarifaBolivar'], 2, ",", ".") ?><p>
<?php
}