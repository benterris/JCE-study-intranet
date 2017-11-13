
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
            <li class="active"><?= $this->Html->link('Accueil bénévoles', ['action' => 'accueil']) ?></li>
            <li><?= $this->Html->link('Mon historique', ['action' => 'old_interventions_volunteer']) ?></li>
        </ul>
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <?= $this->Flash->render() ?>
        <h1 class="header-title">Bienvenue !</h1>
        <h3 class="sub-header">Vos responsables de pôle</h3>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('Prénom') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Nom') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Téléphone') ?></th>
                    </tr>
                </thead>
                <tbody>
                    
            <?php foreach ($resposPole as $respo): ?>
                    <tr>
                        <td><?= h($respo->first_name) ?></td>
                        <td><?= h($respo->last_name) ?></td>
                        <td><?= h($respo->email) ?></td>
                        <td><?= h($respo->phone_number) ?></td>
                        <td><?= h($respo->poleManaged) ?></td>
                    </tr>
            <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <h2 class="page-header">Liste des interventions à la recherche de bénévoles</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Date') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Lycée') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Adresse') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Pôle') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Thème') ?></th>
                        <th scope="col" class="actions"><?= " " ?></th>
                    </tr>
                </thead>
                <tbody>
            <?php foreach ($interventionsNew as $intervention): ?>
                    <tr>
                        <td><?= h($intervention->id) ?></td>
                        <td><?= h($intervention->possible_dates) ?></td>
                        <td><?= h($intervention->teacher->highschool->highschool_name) ?></td>
                        <td><?= h($intervention->teacher->highschool->address) ?></td>
                        <td><?= h($intervention->pole) ?></td>
                        <td><?= h($intervention->type_intervention) ?></td>
                        <td><?= $this->Html->link('Détails', ['controller' => 'Interventions', 'action' => 'view_new', $intervention['id']]) ?></td>
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
        
        
        
        <h2 class="sub-header">Mes interventions en cours de validation et validées</h2>
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Date') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Lycée') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Adresse') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Pôle') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Thème') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Statut') ?></th>
                    </tr>
                </thead>
                <tbody>
            <?php foreach ($interventionsCandidatedAndApproved as $intervention): ?>
                    <tr>
                        <td>
                            <?php
                                if ($intervention->status == 1) { // en attente de validation
                                    echo h($intervention['date_display']);
                                }
                                elseif ($intervention->status == 2) { // validées
                                    echo h($intervention->date);
                                }
                            ?>
                        </td>
                        <td><?= h($intervention->teacher->highschool->highschool_name) ?></td>
                        <td><?= h($intervention->teacher->highschool->address) ?></td>
                        <td><?= h($intervention->pole) ?></td>
                        <td><?= h($intervention->type_intervention) ?></td>
                        <td>
                            <?php 
                                if($intervention->status == 1) {
                                    echo '<div class="big">&#x231b;</p>';
                                } elseif ($intervention->status == 2) {
                                    echo '<div class="big">&#x2713;</p>'; 
                                }
                            ?>
                        </td>
                      
                        <td>
                           
                            <?php 
                                if($intervention->status == 1) {
                                    echo $this->Html->link('Détails', ['controller' => 'Interventions', 'action' => 'view_candidate', $intervention['id']]);
                                } elseif ($intervention->status == 2) {
                                    echo $this->Html->link('Détails', ['controller' => 'Interventions', 'action' => 'view_final', $intervention['id']]); 
                                }
                            ?>
                     
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
    </div>
</div>
    


