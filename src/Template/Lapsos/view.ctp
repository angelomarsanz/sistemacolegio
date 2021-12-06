<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Acciones') ?></li>
        <li><?= $this->Html->link(__('Listado de lapsos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Agregar nuevo lapso'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Modificar el Lapso'), ['action' => 'edit', $lapso->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Eliminar el Lapso'), ['action' => 'delete', $lapso->id], ['confirm' => __('Está usted seguro de que desea modificar el lapso # {0}?', $lapso->numero_lapso)]) ?> </li>
    </ul>
</nav>
<div class="lapsos view large-9 medium-8 columns content">
    <h5>Identificador: <?= h($lapso->id) ?></h5>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Periodo escolar:') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= h($lapso->periodo_escolar) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Número de lapso:') ?>&nbsp;&nbsp;&nbsp;</th>
            <td><?= $this->Number->format($lapso->numero_lapso) ?></td>
        </tr>
    </table>
</div>