
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
            <?php if($loggedIn['role'] == 'poleManager'): ?>
            <li><?= $this->Html->link('Accueil', ['controller' => 'users', 'action' => 'accueil']) ?></li>
            <li class="active"><?= $this->Html->link('Interventions à valider', ['controller' => 'users', 'action' => 'toValidateInterventions']) ?></li>
            <li><?= $this->Html->link('Interventions à affecter', ['controller' => 'users', 'action' => 'toAssignInterventions']) ?></li>
            <li><?= $this->Html->link('Historique', ['controller' => 'users', 'action' => 'oldInterventionsRespoPole']) ?></li>
            <?php elseif ($loggedIn['role'] == 'admin') : {} ?>
            <li><?= $this->Html->link('Accueil', ['controller' => 'users', 'action' => 'accueil']) ?></li>
            <li><?= $this->Html->link('Liste des bénévoles', ['controller' => 'users', 'action' => 'listBenevoles']) ?></li>
            <li><?= $this->Html->link('Liste des professeurs', ['controller' => 'users', 'action' => 'listProfesseurs']) ?></li>
            <li><?= $this->Html->link('Liste des lycées', ['controller' => 'users', 'action' => 'listLycees']) ?></li>
            <li><?= $this->Html->link('Liste des responsables de pôle', ['controller' => 'users', 'action' => 'listResposPole']) ?></li>
            <li><?= $this->Html->link('Comptes en attente de validation', ['controller' => 'users', 'action' => 'adminValidateUsers']) ?></li>
            <li><?= $this->Html->link('Ajouter un utilisateur', ['controller' => 'users', 'action' => 'adminAdd']) ?></li>
            <li class="active"><?= $this->Html->link('Interventions à valider', ['controller' => 'users', 'action' => 'toValidateInterventions']) ?></li>
            <li><?= $this->Html->link('Interventions à affecter', ['controller' => 'users', 'action' => 'toAssignInterventions']) ?></li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <?= $this->Flash->render() ?>
        <h1 class="page-header">Interventions en attente de validation</h1>
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
                        <th scope="col" class="actions"><?= " " ?></th>
                    </tr>
                </thead>
                <tbody>
            <?php foreach ($interventions as $intervention): ?>
                    <tr>
                        <td><?= h($intervention->id) ?></td>
                        <td><?= h($intervention->possible_dates) ?></td>
                        <td><?= h($intervention->teacher->highschool->highschool_name) ?></td>
                        <td><?= h($intervention->teacher->highschool->address) ?></td>
                        <td><?= h($intervention->type_intervention) ?></td>
                        <td><?= h($intervention->pole) ?></td>
                        <td><?= $this->Html->link('Détails', ['controller' => 'Interventions', 'action' => 'view_validate', $intervention['id']]) ?></td>
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
    
