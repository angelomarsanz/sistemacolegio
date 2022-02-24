<h3>Representantes Actualizados</h3>
<?php $contadorRepresentantesActualizados = 1; ?>
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
        <?php foreach ($representantesActualizados as $representante): ?>
            <tr>
                <td><?= $contadorRepresentantesActualizados ?></td>
                <td><?= $representante['cedula'] ?></td>
                <td><?= $representante['nombre'] ?></td>
                <td><?= $representante['id'] ?></td>
            </tr>
        <?php $contadorRepresentantesActualizados++ ?>
        <?php endforeach; ?>
    </tbody>
</table>
<h3>Representantes No Actualizados</h3>
<?php $contadorRepresentantesNoActualizados = 1; ?>
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
        <?php foreach ($representantesNoActualizados as $representanteNA): ?>
            <tr>
                <td><?= $contadorRepresentantesNoActualizados ?></td>
                <td><?= $representanteNA['cedula'] ?></td>
                <td><?= $representanteNA['nombre'] ?></td>
                <td><?= $representanteNA['id'] ?></td>
            </tr>
        <?php $contadorRepresentantesNoActualizados++ ?>
        <?php endforeach; ?>
    </tbody>
</table>
<h3>Representantes Duplicados</h3>
<?php $contadorRepresentantesDuplicados = 1; ?>
<table class="table">
    <thead>
        <tr>
            <th>Nro.</th>
            <th>Cédula</th>
            <th>Nombre</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($representantesDuplicados as $representanteD): ?>
            <tr>
                <td><?= $contadorRepresentantesDuplicados ?></td>
                <td><?= $representanteD['cedula'] ?></td>
                <td><?= $representanteD['nombre'] ?></td>
            </tr>
        <?php $contadorRepresentantesDuplicados++ ?>
        <?php endforeach; ?>
    </tbody>
</table>