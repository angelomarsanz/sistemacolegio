<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Message'), ['action' => 'edit', $message->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Message'), ['action' => 'delete', $message->id], ['confirm' => __('Are you sure you want to delete # {0}?', $message->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Messages'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Message'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="messages view large-9 medium-8 columns content">
    <h3><?= h($message->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $message->has('user') ? $this->Html->link($message->user->id, ['controller' => 'Users', 'action' => 'view', $message->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registration Status') ?></th>
            <td><?= h($message->registration_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Reason Status') ?></th>
            <td><?= h($message->reason_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Responsible User') ?></th>
            <td><?= h($message->responsible_user) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($message->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Status') ?></th>
            <td><?= h($message->date_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($message->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($message->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Text1') ?></h4>
        <?= $this->Text->autoParagraph(h($message->text1)); ?>
    </div>
    <div class="row">
        <h4><?= __('Text2') ?></h4>
        <?= $this->Text->autoParagraph(h($message->text2)); ?>
    </div>
    <div class="row">
        <h4><?= __('Text3') ?></h4>
        <?= $this->Text->autoParagraph(h($message->text3)); ?>
    </div>
</div>
