<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Listado de Lapsos'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="lapsos form large-9 medium-8 columns content">
    <?= $this->Form->create($lapso) ?>
    <fieldset>
        <legend><?= __('Agregar un Nuevo Lapso') ?></legend>
        <?php
            echo $this->Form->input('periodo_escolar', ['label' => 'Período escolar: *', 'options' => [null => '', '2021-2022' =>  '2021-2022', '2022-2023' => '2022-2023']]);
            echo $this->Form->input('numero_lapso', ['label' => 'Número de lapso: *', 'options' => [null => '', '1' =>  '1', '2' => '2', '3' => '3']]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Registrar')) ?>
    <?= $this->Form->end() ?>
</div>
