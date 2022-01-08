<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <?= $this->Html->link('Agregar nueva opcion', ['controller' => 'OpcionesUsuarios', 'action' => 'add'], ['class' => 'btn btn-sm btn-default']); ?>
            <h4><?= __('Opciones de usuario') ?></h4>
        </div>
        <div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Lapso</th>
                        <th scope="col">Materia</th>
                        <th scope="col">Tipo de opción</th>
                        <th scope="col">Opción</th>
                        <th scope="col" class="actions"><?= __('Acciones') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($opcionesUsuarios as $opcionesUsuario): ?>
                    <tr>
                        <td><?= $opcionesUsuario->has('lapso') ? $this->Html->link($opcionesUsuario->lapso->numero_lapso, ['controller' => 'Lapsos', 'action' => 'view', $opcionesUsuario->lapso->id]) : '' ?></td>
                        <td><?= $opcionesUsuario->has('materia') ? $this->Html->link($opcionesUsuario->materia->full_name, ['controller' => 'Materias', 'action' => 'view', $opcionesUsuario->materia->id]) : '' ?></td>
                        <td><?= h($opcionesUsuario->tipo_opcion) ?></td>
                        <td><?= h($opcionesUsuario->descripcion_opcion) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $opcionesUsuario->id], ['class' => 'btn btn-sm btn-default']) ?>
                            <?= $this->Html->link(__('Modificar'), ['action' => 'edit', $opcionesUsuario->id], ['class' => 'btn btn-sm btn-default']) ?>
                            <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $opcionesUsuario->id], ['confirm' => __('Está usted seguro de que desea eliminar la opción {0}?', $opcionesUsuario->descripcion_opcion), 'class' => 'btn btn-sm btn-default']) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('Siguiente') . ' >') ?>
            </ul>
            <p><?= $this->Paginator->counter() ?></p>
        </div>
    </div>
</div>