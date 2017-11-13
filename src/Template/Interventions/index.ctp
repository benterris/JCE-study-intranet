<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Intervention'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sections'), ['controller' => 'Sections', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Section'), ['controller' => 'Sections', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="interventions index large-9 medium-8 columns content">
    <?= $this->Flash->render() ?>
    <h3><?= __('Interventions') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id_volunteer') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id_highschool') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id_teacher') ?></th>
                <th scope="col"><?= $this->Paginator->sort('section_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_intervention_starts') ?></th>
                <th scope="col"><?= $this->Paginator->sort('length_intervention') ?></th>
                <th scope="col"><?= $this->Paginator->sort('intervention_realised') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($interventions as $intervention): ?>
            <tr>
                <td><?= $this->Number->format($intervention->id) ?></td>
                <td><?= $this->Number->format($intervention->user_id_volunteer) ?></td>
                <td><?= $this->Number->format($intervention->user_id_highschool) ?></td>
                <td><?= $this->Number->format($intervention->user_id_teacher) ?></td>
                <td><?= $intervention->has('section') ? $this->Html->link($intervention->section->name, ['controller' => 'Sections', 'action' => 'view', $intervention->section->id]) : '' ?></td>
                <td><?= h($intervention->date_intervention_starts) ?></td>
                <td><?= h($intervention->length_intervention) ?></td>
                <td><?= h($intervention->intervention_realised) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $intervention->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $intervention->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $intervention->id], ['confirm' => __('Are you sure you want to delete # {0}?', $intervention->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} sur {{pages}}')]) ?></p>
    </div>
</div>
