<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Observacions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="observacions form large-9 medium-8 columns content">
    <?= $this->Form->create($observacion) ?>
    <fieldset>
        <legend><?= __('Add Observacion') ?></legend>
        <?php
            echo $this->Form->input('lapso_id', ['options' => $lapsos]);
            echo $this->Form->input('student_id', ['options' => $students]);
            echo $this->Form->input('observacion');
            echo $this->Form->input('registro_elimindo');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
