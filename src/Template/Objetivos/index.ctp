<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <?= $this->Html->link('Agregar nuevo objetivo', ['action' => 'add'], ['class' => 'btn btn-sm btn-default']); ?>
            <h4><?= __('Objetivos') ?></h4>
        </div>
        <div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Materia&nbsp;&nbsp;&nbsp;</th>
                        <th scope="col">Profesor&nbsp;&nbsp;&nbsp;</th>
                        <th scope="col">Lapso&nbsp;&nbsp;&nbsp;</th>
                        <th scope="col">Objetivo&nbsp;&nbsp;&nbsp;</th>
                        <th scope="col">Descripción&nbsp;&nbsp;&nbsp;</th>
                        <th scope="col" class="actions"><?= __('Acciones') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($objetivos as $objetivo): ?>
                    <tr>
                        <td><?= $objetivo->has('materia') ? $this->Html->link($objetivo->materia->full_name, ['controller' => 'Materias', 'action' => 'view', $objetivo->materia->id]) : '' ?>&nbsp;&nbsp;&nbsp;</td>
                        <td><?= $objetivo->has('profesor') ? $this->Html->link($objetivo->profesor->primer_apellido . ' ' . $objetivo->profesor->primer_nombre, ['controller' => 'Profesors', 'action' => 'view', $objetivo->profesor->id]) : '' ?>&nbsp;&nbsp;&nbsp;</td>
                        <td><?= $objetivo->has('lapso') ? $this->Html->link($objetivo->lapso->numero_lapso, ['controller' => 'Lapsos', 'action' => 'view', $objetivo->lapso->id]) : '' ?>&nbsp;&nbsp;&nbsp;</td>
                        <td><?= $objetivo->objetivo ?>&nbsp;&nbsp;&nbsp;</td>
                        <td><?= substr($objetivo->descripcion_objetivo, 0, 15) ?>...&nbsp;&nbsp;&nbsp;</td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $objetivo->id], ['class' => 'btn btn-sm btn-default']) ?>
                            <?= $this->Html->link(__('Modificar'), ['action' => 'edit', $objetivo->id], ['class' => 'btn btn-sm btn-default']) ?>
                            <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $objetivo->id], ['confirm' => __('Está usted seguro que desea eliminar el objetivo {0}?', $objetivo->objetivo), 'class' => 'btn btn-sm btn-default']) ?>
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