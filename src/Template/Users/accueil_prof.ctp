
<div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
        <ul class="nav nav-sidebar">
            <li>
                <div align="center">
                <?=$this->Html->image('logo-XXX.jpg', ['alt' => 'C\'possible logo', 'class' => 'img-thumbnail', 'align' => 'center']) ?>
                </div>
            </li>
        </ul>
        <ul class="nav nav-sidebar">
            <li class="active"><?= $this->Html->link('Accueil professeur', ['action' => 'accueil']) ?></li>
            <li><?= $this->Html->link('Demander une intervention', ['controller' => 'Interventions', 'action' => 'ask']) ?></li>
            <li><?= $this->Html->link('Mon historique', ['action' => 'oldInterventionsTeacher']) ?></li>
        </ul>
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <?= $this->Flash->render() ?>
        <h2 class="sub-header">Interventions confirmées dans mes classes</h2>
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Date') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Lycée') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Adresse') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Thème') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Pôle') ?></th>
                    </tr>
                </thead>
                <tbody>
            <?php foreach ($interventionsPlanned as $intervention): ?>
                    <tr>
                        <td><?= h($intervention->id) ?></td>
                        <td><?= h($intervention->date) ?></td>
                        <td><?= h($intervention->teacher->highschool->highschool_name) ?></td>
                        <td><?= h($intervention->teacher->highschool->address) ?></td>
                        <td><?= h($intervention->type_intervention) ?></td>
                        <td><?= h($intervention->pole) ?></td>
                        <td><?= $this->Html->link('Détails', ['controller' => 'Interventions', 'action' => 'viewFinal', $intervention['id']]); ?></td>
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
        <h2 class="sub-header">Interventions en attente de bénévole</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Dates proposées') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Lycée') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Adresse') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Thème') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Pôle') ?></th>
                        <th scope="col" class="actions"><?= " " ?></th>
                    </tr>
                </thead>
                <tbody>
            <?php foreach ($interventionsNotAssigned as $intervention): ?>
                    <tr>
                        <td><?= h($intervention->id) ?></td>
                        <td><?= h($intervention->possible_dates) ?></td>
                        <td><?= h($intervention->teacher->highschool->highschool_name) ?></td>
                        <td><?= h($intervention->teacher->highschool->address) ?></td>
                        <td><?= h($intervention->type_intervention) ?></td>
                        <td><?= h($intervention->pole) ?></td>
                        <td><?= $this->Html->link('Détails', ['controller' => 'Interventions', 'action' => 'viewAskedTeacher', $intervention['id']]) ?></td>
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
        <h2 class="sub-header">Interventions demandées</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Dates proposées') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Lycée') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Adresse') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Thème') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Pôle') ?></th>
                        <th scope="col" class="actions"><?= " " ?></th>
                    </tr>
                </thead>
                <tbody>
            <?php foreach ($interventionsNotValidated as $intervention): ?>
                    <tr>
                        <td><?= h($intervention->id) ?></td>
                        <td><?= h($intervention->possible_dates) ?></td>
                        <td><?= h($intervention->teacher->highschool->highschool_name) ?></td>
                        <td><?= h($intervention->teacher->highschool->address) ?></td>
                        <td><?= h($intervention->type_intervention) ?></td>
                        <td><?= h($intervention->pole) ?></td>
                        <td><?= $this->Html->link('Détails', ['controller' => 'Interventions', 'action' => 'viewAskedTeacher', $intervention['id']]) ?></td>
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
    </div>
</div>
    


