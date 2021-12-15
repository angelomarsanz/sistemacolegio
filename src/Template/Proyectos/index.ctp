<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <?= $this->Html->link('Agregar nuevo proyecto', ['controller' => 'Proyectos', 'action' => 'add'], ['class' => 'btn btn-sm btn-default']); ?>
            <h4><?= __('Proyectos: ' . $materia->section->full_name) ?></h4>
        </div>
        <div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Identificador proyecto</th>
                        <th scope="col">Descripcion proyecto</th>
                        <th scope="col" class="actions"><?= __('Acciones') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($proyectos as $proyecto): ?>
                    <tr>
                        <td><?= h($proyecto->identificador_proyecto) ?></td>
                        <td><?= substr($proyecto->descripcion_proyecto, 0, 40) ?>...</td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $proyecto->id], ['class' => 'btn btn-sm btn-default']) ?>
                            <?= $this->Html->link(__('Modificar'), ['action' => 'edit', $proyecto->id], ['class' => 'btn btn-sm btn-default']) ?>
                            <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $proyecto->id], ['class' => 'btn btn-sm btn-default', 'confirm' => __('Está usted seguro de que desea eliminar el proyecto {0}?', $proyecto->identificador_proyecto)]) ?>
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