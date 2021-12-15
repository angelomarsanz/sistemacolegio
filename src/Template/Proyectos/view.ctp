<div class="container">
    <div class="page-header">    
        <?= $this->Html->link(__('Modificar el proyecto'), ['action' => 'edit', $proyecto->id], ['class' => 'btn btn-sm btn-default']) ?>
        <?= $this->Form->postLink(__('Eliminar el proyecto'), ['action' => 'delete', $proyecto->id], ['class' => 'btn btn-sm btn-default', 'confirm' => __('Está usted seguro de que desea eliminar el proyecto {0}?', $proyecto->identificador_proyecto)]) ?>
        <?= $this->Html->link(__('Agregar nuevo proyecto'), ['action' => 'add'], ['class' => 'btn btn-sm btn-default']) ?>
        <h2>Proyecto:&nbsp;<?= $proyecto->identificador_proyecto ?></h2>
    </div>
    <div class="row">
        <div class="col col-sm-12">
            <table class="vertical-table">
                <tr>
                    <th scope="row"><?= __('Lapso:') ?>&nbsp;&nbsp;&nbsp;</th>
                    <td><?= $proyecto->has('lapso') ? $this->Html->link($proyecto->lapso->numero_lapso, ['controller' => 'Lapsos', 'action' => 'view', $proyecto->lapso->id]) : '' ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Descripcion del proyecto:') ?>&nbsp;&nbsp;&nbsp;</th>
                    <td><?= h($proyecto->descripcion_proyecto) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Instrumento del proyecto:') ?>&nbsp;&nbsp;&nbsp;</th>
                    <td><?= h($proyecto->instrumento_proyecto) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Comentario proyecto:') ?>&nbsp;&nbsp;&nbsp;</th>
                    <td><?= h($proyecto->comentario_proyecto) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Ponderacion proyecto:') ?>&nbsp;&nbsp;&nbsp;</th>
                    <td><?= $this->Number->format($proyecto->ponderacion_proyecto) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Fecha proyecto:') ?>&nbsp;&nbsp;&nbsp;</th>
                    <td><?= h($proyecto->fecha_proyecto) ?></td>
                </tr>
                <tr>
            </table>
        </div>
    </div>
</div>
