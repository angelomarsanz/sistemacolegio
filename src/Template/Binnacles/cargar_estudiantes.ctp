<br />
<br />
<h3>Estudiantes no Registrados</h3>
<?php
if ($contadorEstudiantesNoRegistrados > 0)
{
    foreach ($estudiantesNoRegistrados as $noRegistrado)
    { 
    ?>
        <p><?= $noRegistrado['cedula'] . ' ' . $noRegistrado['nombre'] ?></p>
    <?php    
    }
}
?>
<br />
<br />
<h3>Estudiantes con Cédula Duplicada</h3>
<?php
if ($contadorEstudiantesCedulaDuplicada > 0)
{
    foreach ($estudiantesConCedulaDuplicada as $duplicada)
    { 
    ?>
        <p><?= $duplicada['cedula'] . ' ' . $duplicada['nombre'] ?></p>
    <?php    
    }
}
?>
<br />
<br />
<h3>Estudiantes Repetidos</h3>
<?php
if ($contadorEstudiantesRepetidos > 0)
{
    foreach ($estudiantesRepetidos as $repetido)
    { 
    ?>
        <p><?= $repetido['cedula'] . ' ' . $repetido['nombre'] ?></p>
    <?php    
    }
}