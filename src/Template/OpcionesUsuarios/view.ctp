<div class="container">
    <div class="page-header">    
        <?= $this->Html->link(__('Modificar la opción'), ['action' => 'edit', $opcionesUsuario->id], ['class' => 'btn btn-sm btn-default']) ?>
        <?= $this->Form->postLink(__('Eliminar la opción'), ['action' => 'delete', $opcionesUsuario->id], ['class' => 'btn btn-sm btn-default', 'confirm' => __('Está usted seguro de que desea eliminar la opcion {0}?', $opcionesUsuario->descripcion_opcion)]) ?>
        <?= $this->Html->link(__('Agregar nueva opcion'), ['action' => 'add'], ['class' => 'btn btn-sm btn-default']) ?>
        <h2>Opción</h2>
    </div>
    <div class="row">
        <div class="col col-sm-12">
            <table class="vertical-table">
                <tr>
                    <th scope="row"><?= __('Lapso:') ?>&nbsp;&nbsp;&nbsp;</th>
                    <td><?= $opcionesUsuario->has('lapso') ? $this->Html->link($opcionesUsuario->lapso->id, ['controller' => 'Lapsos', 'action' => 'view', $opcionesUsuario->lapso->id]) : '' ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Materia:') ?>&nbsp;&nbsp;&nbsp;</th>
                    <td><?= $opcionesUsuario->has('materia') ? $this->Html->link($opcionesUsuario->materia->id, ['controller' => 'Materias', 'action' => 'view', $opcionesUsuario->materia->id]) : '' ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Tipo de opcion:') ?>&nbsp;&nbsp;&nbsp;</th>
                    <td><?= h($opcionesUsuario->tipo_opcion) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Opcion:') ?>&nbsp;&nbsp;&nbsp;</th>
                    <td><?= h($opcionesUsuario->descripcion_opcion) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>