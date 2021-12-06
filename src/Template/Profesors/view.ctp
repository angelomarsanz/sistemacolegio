<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Acciones') ?></li>
        <li><?= $this->Html->link(__('Lista de profesores'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Agregar un nuevo profesor'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Modificar el profesor'), ['action' => 'edit', $profesor->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Eliminar el profesor'), ['action' => 'delete', $profesor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $profesor->id)]) ?> </li>
    </ul>
</nav>
<div class="profesors view large-9 medium-8 columns content">
    <h5>Identificador: <?= h($profesor->id) ?></h5>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Cédula/pasaporte:') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= h($profesor->tipo_documento_identificacion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nacionalidad:') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= h($profesor->nacionalidad) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Apellidos y nombres:') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= h($profesor->full_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sexo:') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= h($profesor->sexo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Título universitario:') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= h($profesor->titulo_universitario) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Dirección de habitación:') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= h($profesor->direccion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Número de celular:') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= h($profesor->celular) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Número de teléfono fijo:') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= h($profesor->telefono_fijo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Correo electrónico:') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= h($profesor->correo_electronico) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Número de horas:') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= h($profesor->numero_horas) ?></td>
        </tr>
    </table>
    <?php echo '<br /><br />'; ?>
    <div class="related">
        <h4><?= __('Materias que dicta el profesor') ?></h4>
        <?php if (!empty($materiasProfesor)): ?>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th scope="col"><?= __('Nombre') ?>&nbsp;&nbsp;&nbsp;</th>
                    <th scope="col"><?= __('Grado') ?>&nbsp;&nbsp;&nbsp;</th>
                    <th scope="col" class="actions"><?= __('Acciones') ?></th>
                </tr>
                <?php foreach ($materiasProfesor as $materiasProf): ?>
                <tr>
                    <td><?= h($materiasProf->materia->nombre_materia) ?>&nbsp;&nbsp;&nbsp;</td>
                    <td><?= h($materiasProf->materia->grado_materia) ?>&nbsp;&nbsp;&nbsp;</td>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['controller' => 'Materias', 'action' => 'view', $materiasProf->materia->id]) ?>
                        <?= $this->Html->link(__('Modificar'), ['controller' => 'Materias', 'action' => 'edit', $materiasProf->materia->id]) ?>
                        <?= $this->Form->postLink(__('Eliminar'), ['controller' => 'Materias', 'action' => 'delete', $materiasProf->materia->id], ['confirm' => __('Está seguro de que desea eliminar esta materia {0}?', $materiasProf->materia->nombre_materia . '-' . $materiasProf->materia->grado_materia)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>