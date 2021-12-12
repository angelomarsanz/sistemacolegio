<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Literal Ano'), ['action' => 'edit', $literalAno->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Literal Ano'), ['action' => 'delete', $literalAno->id], ['confirm' => __('Are you sure you want to delete # {0}?', $literalAno->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Literal Anos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Literal Ano'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="literalAnos view large-9 medium-8 columns content">
    <h3><?= h($literalAno->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Student') ?></th>
            <td><?= $literalAno->has('student') ? $this->Html->link($literalAno->student->full_name, ['controller' => 'Students', 'action' => 'view', $literalAno->student->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Periodo Escolar') ?></th>
            <td><?= h($literalAno->periodo_escolar) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Literal') ?></th>
            <td><?= h($literalAno->literal) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($literalAno->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($literalAno->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($literalAno->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registro Eliminado') ?></th>
            <td><?= $literalAno->registro_eliminado ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Calificacion Descriptiva') ?></h4>
        <?= $this->Text->autoParagraph(h($literalAno->calificacion_descriptiva)); ?>
    </div>
</div>
