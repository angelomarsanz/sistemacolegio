<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Observacion'), ['action' => 'edit', $observacion->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Observacion'), ['action' => 'delete', $observacion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $observacion->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Observacions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Observacion'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="observacions view large-9 medium-8 columns content">
    <h3><?= h($observacion->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Lapso') ?></th>
            <td><?= $observacion->has('lapso') ? $this->Html->link($observacion->lapso->id, ['controller' => 'Lapsos', 'action' => 'view', $observacion->lapso->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Student') ?></th>
            <td><?= $observacion->has('student') ? $this->Html->link($observacion->student->full_name, ['controller' => 'Students', 'action' => 'view', $observacion->student->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($observacion->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($observacion->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($observacion->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registro Elimindo') ?></th>
            <td><?= $observacion->registro_elimindo ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Observacion') ?></h4>
        <?= $this->Text->autoParagraph(h($observacion->observacion)); ?>
    </div>
</div>
