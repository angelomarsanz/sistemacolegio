<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $migracion->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $migracion->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Migracions'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="migracions form large-9 medium-8 columns content">
    <?= $this->Form->create($migracion) ?>
    <fieldset>
        <legend><?= __('Edit Migracion') ?></legend>
        <?php
            echo $this->Form->input('campo_1');
            echo $this->Form->input('campo_2');
            echo $this->Form->input('campo_3');
            echo $this->Form->input('campo_4');
            echo $this->Form->input('campo_5');
            echo $this->Form->input('campo_6');
            echo $this->Form->input('campo_7');
            echo $this->Form->input('campo_8');
            echo $this->Form->input('campo_9');
            echo $this->Form->input('campo_10');
            echo $this->Form->input('campo_11');
            echo $this->Form->input('campo_12');
            echo $this->Form->input('campo_13');
            echo $this->Form->input('campo_14');
            echo $this->Form->input('campo_15');
            echo $this->Form->input('campo_16');
            echo $this->Form->input('campo_17');
            echo $this->Form->input('campo_18');
            echo $this->Form->input('campo_19');
            echo $this->Form->input('campo_20');
            echo $this->Form->input('campo_21');
            echo $this->Form->input('campo_22');
            echo $this->Form->input('campo_23');
            echo $this->Form->input('campo_24');
            echo $this->Form->input('campo_25');
            echo $this->Form->input('campo_26');
            echo $this->Form->input('campo_27');
            echo $this->Form->input('campo_28');
            echo $this->Form->input('campo_29');
            echo $this->Form->input('campo_30');
            echo $this->Form->input('campo_31');
            echo $this->Form->input('campo_32');
            echo $this->Form->input('campo_33');
            echo $this->Form->input('campo_34');
            echo $this->Form->input('campo_35');
            echo $this->Form->input('campo_36');
            echo $this->Form->input('campo_37');
            echo $this->Form->input('campo_38');
            echo $this->Form->input('campo_39');
            echo $this->Form->input('campo_40');
            echo $this->Form->input('campo_41');
            echo $this->Form->input('campo_42');
            echo $this->Form->input('campo_43');
            echo $this->Form->input('campo_44');
            echo $this->Form->input('campo_45');
            echo $this->Form->input('campo_46');
            echo $this->Form->input('campo_47');
            echo $this->Form->input('campo_48');
            echo $this->Form->input('campo_49');
            echo $this->Form->input('campo_50');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
