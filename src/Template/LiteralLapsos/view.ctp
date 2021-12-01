<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Literal Lapso'), ['action' => 'edit', $literalLapso->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Literal Lapso'), ['action' => 'delete', $literalLapso->id], ['confirm' => __('Are you sure you want to delete # {0}?', $literalLapso->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Literal Lapsos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Literal Lapso'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Lapsos'), ['controller' => 'Lapsos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Lapso'), ['controller' => 'Lapsos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="literalLapsos view large-9 medium-8 columns content">
    <h3><?= h($literalLapso->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Lapso') ?></th>
            <td><?= $literalLapso->has('lapso') ? $this->Html->link($literalLapso->lapso->id, ['controller' => 'Lapsos', 'action' => 'view', $literalLapso->lapso->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Student') ?></th>
            <td><?= $literalLapso->has('student') ? $this->Html->link($literalLapso->student->full_name, ['controller' => 'Students', 'action' => 'view', $literalLapso->student->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Literal') ?></th>
            <td><?= h($literalLapso->literal) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($literalLapso->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($literalLapso->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($literalLapso->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registro Eliminado') ?></th>
            <td><?= $literalLapso->registro_eliminado ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Calificacion Descriptiva') ?></h4>
        <?= $this->Text->autoParagraph(h($literalLapso->calificacion_descriptiva)); ?>
    </div>
</div>
