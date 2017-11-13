<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Intervention'), ['action' => 'edit', $intervention->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Intervention'), ['action' => 'delete', $intervention->id], ['confirm' => __('Are you sure you want to delete # {0}?', $intervention->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Interventions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Intervention'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sections'), ['controller' => 'Sections', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Section'), ['controller' => 'Sections', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="interventions view large-9 medium-8 columns content">
    <?= $this->Flash->render() ?>
    <h3><?= h($intervention->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Section') ?></th>
            <td><?= $intervention->has('section') ? $this->Html->link($intervention->section->name, ['controller' => 'Sections', 'action' => 'view', $intervention->section->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($intervention->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id Volunteer') ?></th>
            <td><?= $this->Number->format($intervention->user_id_volunteer) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id Highschool') ?></th>
            <td><?= $this->Number->format($intervention->user_id_highschool) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id Teacher') ?></th>
            <td><?= $this->Number->format($intervention->user_id_teacher) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Intervention Starts') ?></th>
            <td><?= h($intervention->date_intervention_starts) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date') ?></th>
            <td><?= h($intervention->date)?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Length Intervention') ?></th>
            <td><?= h($intervention->length_intervention) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Intervention Realised') ?></th>
            <td><?= $intervention->intervention_realised ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Pole') ?></h4>
        <?= $this->Text->autoParagraph(h($intervention->pole)); ?>
    </div>
    <div class="row">
        <h4><?= __('Type Intervention') ?></h4>
        <?= $this->Text->autoParagraph(h($intervention->type_intervention)); ?>
    </div>
    <div class="row">
        <h4><?= __('Feedback Prof') ?></h4>
        <?= $this->Text->autoParagraph(h($intervention->feedback_prof)); ?>
    </div>
    <div class="row">
        <h4><?= __('Feedback Intervenant') ?></h4>
        <?= $this->Text->autoParagraph(h($intervention->feedback_intervenant)); ?>
    </div>
</div>
