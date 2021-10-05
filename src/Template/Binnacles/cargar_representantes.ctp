<br />
<br />
<h3>Representantes con Cédula Duplicada</h3>
<?php
if ($contadorRepresentantesCedulaDuplicada > 0)
{
    foreach ($representantesConCedulaDuplicada as $duplicada)
    { 
    ?>
        <p><?= $duplicada['cedula'] . ' ' . $duplicada['nombre'] ?></p>
    <?php    
    }
}
?>
<br />
<br />
<h3>Representantes con Varios Hijos</h3>
<?php
if ($contadorRepresentanteVariosHijos > 0)
{
    foreach ($representantesConVariosHijos as $hijo)
    { 
    ?>
        <p><?= $hijo['cedula'] . ' ' . $hijo['nombre'] ?></p>
    <?php    
    }
}