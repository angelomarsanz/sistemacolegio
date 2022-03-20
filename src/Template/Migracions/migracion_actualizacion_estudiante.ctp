<h3>Estudiantes Actualizados</h3>
<?php $contadorEstudiantesActualizados = 1; ?>
<table class="table">
    <thead>
        <tr>
            <th>Nro.</th>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>id</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($estudiantesActualizados as $estudiante): ?>
            <tr>
                <td><?= $contadorEstudiantesActualizados ?></td>
                <td><?= $estudiante['cedula'] ?></td>
                <td><?= $estudiante['nombre'] ?></td>
                <td><?= $estudiante['id'] ?></td>
            </tr>
        <?php $contadorEstudiantesActualizados++ ?>
        <?php endforeach; ?>
    </tbody>
</table>
<h3>Estudiantes No Actualizados</h3>
<?php $contadorEstudiantesNoActualizados = 1; ?>
<table class="table">
    <thead>
        <tr>
            <th>Nro.</th>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>id</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($estudiantesNoActualizados as $estudiante): ?>
            <tr>
                <td><?= $contadorEstudiantesNoActualizados ?></td>
                <td><?= $estudiante['cedula'] ?></td>
                <td><?= $estudiante['nombre'] ?></td>
                <td><?= $estudiante['id'] ?></td>
            </tr>
        <?php $contadorEstudiantesNoActualizados++ ?>
        <?php endforeach; ?>
    </tbody>
</table>
<h3>Estudiantes Duplicados</h3>
<?php $contadorEstudiantesDuplicados = 1; ?>
<table class="table">
    <thead>
        <tr>
            <th>Nro.</th>
            <th>Cédula</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($estudiantesDuplicados as $estudiante): ?>
            <tr>
                <td><?= $contadorEstudiantesDuplicados ?></td>
                <td><?= $estudiante ?></td>
            </tr>
        <?php $contadorEstudiantesDuplicados++ ?>
        <?php endforeach; ?>
    </tbody>
</table>