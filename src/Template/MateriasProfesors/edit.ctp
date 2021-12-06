<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $materiasProfesor->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $materiasProfesor->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Materias Profesors'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Materias'), ['controller' => 'Materias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Materia'), ['controller' => 'Materias', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Profesors'), ['controller' => 'Profesors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Profesor'), ['controller' => 'Profesors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="materiasProfesors form large-9 medium-8 columns content">
    <?= $this->Form->create($materiasProfesor) ?>
    <fieldset>
        <legend><?= __('Edit Materias Profesor') ?></legend>
        <?php
            echo $this->Form->input('materia_id', ['options' => $materias]);
            echo $this->Form->input('profesor_id', ['options' => $profesors]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
