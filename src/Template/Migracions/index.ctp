<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Migracion'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="migracions index large-9 medium-8 columns content">
    <h3><?= __('Migracions') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_1') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_2') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_3') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_4') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_5') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_6') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_7') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_8') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_9') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_10') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_11') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_12') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_13') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_14') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_15') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_16') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_17') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_18') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_19') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_20') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_21') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_22') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_23') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_24') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_25') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_26') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_27') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_28') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_29') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_30') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_31') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_32') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_33') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_34') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_35') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_36') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_37') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_38') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_39') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_40') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_41') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_42') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_43') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_44') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_45') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_46') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_47') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_48') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_49') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campo_50') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($migracions as $migracion): ?>
            <tr>
                <td><?= $this->Number->format($migracion->id) ?></td>
                <td><?= h($migracion->campo_1) ?></td>
                <td><?= h($migracion->campo_2) ?></td>
                <td><?= h($migracion->campo_3) ?></td>
                <td><?= h($migracion->campo_4) ?></td>
                <td><?= h($migracion->campo_5) ?></td>
                <td><?= h($migracion->campo_6) ?></td>
                <td><?= h($migracion->campo_7) ?></td>
                <td><?= h($migracion->campo_8) ?></td>
                <td><?= h($migracion->campo_9) ?></td>
                <td><?= h($migracion->campo_10) ?></td>
                <td><?= h($migracion->campo_11) ?></td>
                <td><?= h($migracion->campo_12) ?></td>
                <td><?= h($migracion->campo_13) ?></td>
                <td><?= h($migracion->campo_14) ?></td>
                <td><?= h($migracion->campo_15) ?></td>
                <td><?= h($migracion->campo_16) ?></td>
                <td><?= h($migracion->campo_17) ?></td>
                <td><?= h($migracion->campo_18) ?></td>
                <td><?= h($migracion->campo_19) ?></td>
                <td><?= h($migracion->campo_20) ?></td>
                <td><?= h($migracion->campo_21) ?></td>
                <td><?= h($migracion->campo_22) ?></td>
                <td><?= h($migracion->campo_23) ?></td>
                <td><?= h($migracion->campo_24) ?></td>
                <td><?= h($migracion->campo_25) ?></td>
                <td><?= h($migracion->campo_26) ?></td>
                <td><?= h($migracion->campo_27) ?></td>
                <td><?= h($migracion->campo_28) ?></td>
                <td><?= h($migracion->campo_29) ?></td>
                <td><?= h($migracion->campo_30) ?></td>
                <td><?= h($migracion->campo_31) ?></td>
                <td><?= h($migracion->campo_32) ?></td>
                <td><?= h($migracion->campo_33) ?></td>
                <td><?= h($migracion->campo_34) ?></td>
                <td><?= h($migracion->campo_35) ?></td>
                <td><?= h($migracion->campo_36) ?></td>
                <td><?= h($migracion->campo_37) ?></td>
                <td><?= h($migracion->campo_38) ?></td>
                <td><?= h($migracion->campo_39) ?></td>
                <td><?= h($migracion->campo_40) ?></td>
                <td><?= h($migracion->campo_41) ?></td>
                <td><?= h($migracion->campo_42) ?></td>
                <td><?= h($migracion->campo_43) ?></td>
                <td><?= h($migracion->campo_44) ?></td>
                <td><?= h($migracion->campo_45) ?></td>
                <td><?= h($migracion->campo_46) ?></td>
                <td><?= h($migracion->campo_47) ?></td>
                <td><?= h($migracion->campo_48) ?></td>
                <td><?= h($migracion->campo_49) ?></td>
                <td><?= h($migracion->campo_50) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $migracion->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $migracion->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $migracion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $migracion->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
