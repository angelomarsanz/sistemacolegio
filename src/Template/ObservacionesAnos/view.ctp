<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Observaciones Ano'), ['action' => 'edit', $observacionesAno->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Observaciones Ano'), ['action' => 'delete', $observacionesAno->id], ['confirm' => __('Are you sure you want to delete # {0}?', $observacionesAno->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Observaciones Anos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Observaciones Ano'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="observacionesAnos view large-9 medium-8 columns content">
    <h3><?= h($observacionesAno->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Student') ?></th>
            <td><?= $observacionesAno->has('student') ? $this->Html->link($observacionesAno->student->full_name, ['controller' => 'Students', 'action' => 'view', $observacionesAno->student->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Periodo Escolar') ?></th>
            <td><?= h($observacionesAno->periodo_escolar) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipo Observacion') ?></th>
            <td><?= h($observacionesAno->tipo_observacion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($observacionesAno->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($observacionesAno->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($observacionesAno->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registro Eliminado') ?></th>
            <td><?= $observacionesAno->registro_eliminado ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Parrafo 1') ?></h4>
        <?= $this->Text->autoParagraph(h($observacionesAno->parrafo_1)); ?>
    </div>
    <div class="row">
        <h4><?= __('Parrafo 2') ?></h4>
        <?= $this->Text->autoParagraph(h($observacionesAno->parrafo_2)); ?>
    </div>
    <div class="row">
        <h4><?= __('Parrafo 3') ?></h4>
        <?= $this->Text->autoParagraph(h($observacionesAno->parrafo_3)); ?>
    </div>
    <div class="row">
        <h4><?= __('Parrafo 4') ?></h4>
        <?= $this->Text->autoParagraph(h($observacionesAno->parrafo_4)); ?>
    </div>
    <div class="row">
        <h4><?= __('Parrafo 5') ?></h4>
        <?= $this->Text->autoParagraph(h($observacionesAno->parrafo_5)); ?>
    </div>
</div>
