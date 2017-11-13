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
            <li><?= $this->Html->link('Accueil professeur', ['controller' => 'Users', 'action' => 'accueil']) ?></li>
            <li><?= $this->Html->link('Demander une intervention', ['controller' => 'Interventions', 'action' => 'ask']) ?></li>
            <li><?= $this->Html->link('Mon historique', ['controller' => 'Users', 'action' => 'oldInterventionsTeacher']) ?></li>
        </ul>
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <?= $this->Flash->render() ?>
        <div class="row">
            <div class="col-sm-6">
                <h1 class="page-header">Détails de l'intervention</h1>
        <table class="vertical-table">
            <tr>
                <th scope="row"><?= 'Id : ' ?></th>
                <td class="view_new"><?= h($intervention->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= 'Nom du lycée : ' ?></th>
                <td class="view_new"><?= h($intervention->teacher->highschool->highschool_name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= "Pôle : " ?></th>
                <td class="view_new"><?= h($intervention->pole) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= "Nom du professeur : " ?></th>
                <td class="view_new"><?= h($intervention->teacher->first_name) . " " . h($intervention->teacher->last_name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= "Créneaux proposés : " ?></th>
                <td class="view_new"><?= h($intervention->possible_dates) ?></td>
            </tr>
            <!--<tr>
                <th scope="row"><?= "Durée : " ?></th>
                <td class="view_new"><?= h($intervention->length_intervention) ?></td>
            </tr> -->
            <tr>
                <th scope="row"><?= "Description de l'intervention : " ?></th>
                <td class="view_new"><?= h($intervention->type_intervention) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= "Détails : " ?></th>
                <td class="view_new"><?= h($intervention->comment) ?></td>
            </tr>
            
            <tr>
                <th scope="row"><?= "Adresse de l'établissement : " ?></th>
                <td class="view_new"><?= h($intervention->teacher->highschool->address) ?></td>
            </tr>
        </table>    
                <br>
                <?= $this->Form->postLink('<button class="btn btn-primary">Retirer ma demande</button>', ['controller' => 'Users', 'action' => 'cancelAsk', $intervention['id']], ['escape' => false, 'confirm' => "Êtes-vous certain de vouloir retirer cette demande d'intervention ?"]) ?>
            </div>
        </div>
        
    </div>
</div> 
   


