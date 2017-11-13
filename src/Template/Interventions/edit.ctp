<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $intervention->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $intervention->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Interventions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Sections'), ['controller' => 'Sections', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Section'), ['controller' => 'Sections', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="interventions form large-9 medium-8 columns content">
    <?= $this->Flash->render() ?>
    <?= $this->Form->create($intervention) ?>
    <fieldset>
        <legend><?= __('Edit Intervention') ?></legend>
        <?php
            echo $this->Form->input('user_id_volunteer');
            echo $this->Form->input('user_id_highschool');
            echo $this->Form->input('user_id_teacher');
            echo $this->Form->input('section_id', ['options' => $sections, 'empty' => true]);
            echo $this->Form->input('pole');
            echo $this->Form->input('type_intervention');
            echo $this->Form->input('date_intervention_starts', ['empty' => true]);
            echo $this->Form->input('length_intervention', ['empty' => true]);
            echo $this->Form->input('feedback_prof');
            echo $this->Form->input('feedback_intervenant');
            echo $this->Form->input('intervention_realised');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
