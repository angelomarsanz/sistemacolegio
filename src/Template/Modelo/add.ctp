<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Materias'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="materias form large-9 medium-8 columns content">
    <?= $this->Form->create($materia) ?>
    <fieldset>
        <legend><?= __('Add Materia') ?></legend>
        <?php
            echo $this->Form->input('section_id', ['options' => $secciones]);
            echo $this->Form->input('nombre_materia');
            echo $this->Form->input('descripcion_materia');
            echo $this->Form->input('cantidad_horas_semanales');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
