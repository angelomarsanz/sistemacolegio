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
        <p><?= $mensualidad['cedula'] . ', ' . $mensualidad['nombre'] . ', ' . $mensualidad['nivel'] . $mensualidad['monto'] . ', pago ' . $mensualidad['abono'] . ', id del Representante ' . $mensualidad['id_representante'] ?></p>
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
<br />
<br />
<h3>Estudiantes no actualizados</h3>
<?php
if ($contadorEstudianteNoActualizado > 0)
{
    foreach ($estudiantesNoActualizados as $estudiante)
    { 
    ?>
        <p><?= $estudiante['cedula'] . ' ' . $estudiatne['nombre'] ?></p>
    <?php    
    }
}
?>
<br />
<br />
<h3>Representantes no actualizados</h3>
<?php
if ($contadorRepresentantesNoActualizados > 0)
{
    foreach ($representantesNoActualizados as $representante)
    { 
    ?>
        <p><?= $representante['cedula'] . ' ' . $representante['nombre'] . ', ' . $representante['motivo'] ?></p>
    <?php    
    }
}
?>