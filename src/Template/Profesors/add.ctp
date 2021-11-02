<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Profesors'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="profesors form large-9 medium-8 columns content">
    <?= $this->Form->create($profesor) ?>
    <fieldset>
        <legend><?= __('Add Profesor') ?></legend>
        <?php
            echo $this->Form->input('section_id', ['options' => $secciones]);
            echo $this->Form->input('nombre_profesor');
            echo $this->Form->input('descripcion_profesor');
            echo $this->Form->input('cantidad_horas_semanales');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
