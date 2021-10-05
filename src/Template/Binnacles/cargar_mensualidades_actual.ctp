<br />
<br />
<h3>Estudiantes no Encontrados</h3>
<?php
if ($contadorEstudiantesNoEncontrados > 0)
{
    foreach ($estudiantesNoEncontrados as $noEncontrado)
    { 
    ?>
        <p><?= $noEncontrado['cedula'] . ', ' . ' idMigracion: ' . $noEncontrado['idMigracion'] ?></p>
    <?php    
    }
}
?>
<br />
<br />
<h3>Mensualidades pendientes mayores a la tarifa</h3>
<?php
if ($contadorMensualidadesMayorTarifa > 0)
{
    foreach ($mensualidadesMayorTarifa as $mensualidad)
    { 
    ?>
        <p><?= $mensualidad['cedula'] . ', ' . $mensualidad['nombre'] . ', ' . $mensualidad['nivel'] . ', mensualidad ' . $mensualidad['mensualidad'] . ', ' . $mensualidad['monto'] . ', ' . $mensualidad['deuda'] ?></p>
    <?php    
    }
}
?>
<br />
<br />
<h3>Transacciones no guardadas</h3>
<?php
if ($contadorTransaccionesNoGuardadas > 0)
{
    foreach ($transaccionesNoGuardadas as $transaccion)
    { 
    ?>
        <p><?= $transaccion['cedula'] . ', ' . ' mensualidad: ' . $transaccion['mensualidad'] . ', ' . $transaccion['monto'] ?></p>
    <?php    
    }
}
?>