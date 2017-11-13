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
            <li><?= $this->Html->link('Interventions à valider', ['controller' => 'users', 'action' => 'toValidateInterventions']) ?></li>
            <li class="active"><?= $this->Html->link('Interventions à affecter', ['controller' => 'users', 'action' => 'toAssignInterventions']) ?></li>
            <li><?= $this->Html->link('Historique', ['controller' => 'users', 'action' => 'oldInterventionsRespoPole']) ?></li>
            <?php elseif ($loggedIn['role'] == 'admin') : {} ?>
            <li><?= $this->Html->link('Accueil', ['controller' => 'users', 'action' => 'accueil']) ?></li>
            <li><?= $this->Html->link('Liste des bénévoles', ['controller' => 'users', 'action' => 'listBenevoles']) ?></li>
            <li><?= $this->Html->link('Liste des professeurs', ['controller' => 'users', 'action' => 'listProfesseurs']) ?></li>
            <li><?= $this->Html->link('Liste des lycées', ['controller' => 'users', 'action' => 'listLycees']) ?></li>
            <li><?= $this->Html->link('Liste des responsables de pôle', ['controller' => 'users', 'action' => 'listResposPole']) ?></li>
            <li><?= $this->Html->link('Comptes en attente de validation', ['controller' => 'users', 'action' => 'adminValidateUsers']) ?></li>
            <li><?= $this->Html->link('Ajouter un utilisateur', ['controller' => 'users', 'action' => 'adminAdd']) ?></li>
            <li><?= $this->Html->link('Interventions à valider', ['controller' => 'users', 'action' => 'toValidateInterventions']) ?></li>
            <li class="active"><?= $this->Html->link('Interventions à affecter', ['controller' => 'users', 'action' => 'toAssignInterventions']) ?></li>
            <?php endif; ?>
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
                <th scope="row"><?= "Mail du professeur : " ?></th>
                <td class="view_new"><?= h($intervention->teacher->email) . " " . h($intervention->teacher->last_name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= "Créneaux proposés : " ?></th>
                <td class="view_new"><?= h($intervention->possible_dates) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= "Description : " ?></th>
                <td class="view_new"><?= h($intervention->type_intervention) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= "Détails : " ?></th>
                <td class="view_new"><?= h($intervention->comment) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= "Adresse de l'établissement :  " ?></th>
                <td class="view_new"><?= h($intervention->teacher->highschool->address) ?></td>
            </tr>
        </table>    
              
        
            </div>
            <div class="col-sm-6">
                <div id="map"></div>
            </div>
        </div>
        <br>
        <h3>Choisir un bénévole parmi les candidats suivants :</h3>
        
        <?= $this->Form->create($intervention, [
            'context' => ['validator' => 'assign']
        ]) ?>
        
       

        <input name="user_id_volunteer" type="hidden">
               
        <div class="table-responsive">
            <table class="table table-stripe">
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('Choix') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Date demandée') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('first_name') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('last_name') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('address') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('phone_number') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('birth_date') ?></th>
                        <!--
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                        -->
                    </tr>
                </thead>
                <tbody>
            <?php foreach ($intervention->candidates as $user): ?>
                    <tr>
                        <td>
                                <input name="user_id_volunteer" value="<?= $user->id ?>" type="radio">
                        </td>
                        <td><?= h($user['date_display']) ?></td>
                        <td><?= h($user->first_name) ?></td>
                        <td><?= h($user->last_name) ?></td>
                        <td><?= h($user->address) ?></td>
                        <td><?= h($user->email) ?></td>
                        <td><?= h($user->phone_number) ?></td>
                        <td><?= h($user->birth_date) ?></td>
                        <td class="actions">
                    <?= $this->Html->link('Détails', ['controller' => 'Users', 'action' => 'view', $user->id]) ?>
                        </td>
                    </tr>
            <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!--
        <?= $this->Form->text('lalala'); ?>
        -->
        <?= $this->Form->button(__('Valider'), ['formnovalidate' => true]) ?>
        <?= $this->Form->end() ?>
        
        
    </div>
</div> 
    





    
        <div id="floating-panel" style = "display:none">
            <input id="address" type="textbox" value="<?= h($intervention->teacher->highschool->address) ?>">
            <input id="submit" type="button" value="Geocode">
        </div>
    
        
    
   <script>
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 14,
          center: {lat: 48.866667, lng: 2.333333}
        });
        var geocoder = new google.maps.Geocoder();
        geocodeAddress(geocoder, map);
        document.getElementById('submit').addEventListener('click', function() {
          geocodeAddress(geocoder, map);
        });
      }

      function geocodeAddress(geocoder, resultsMap) {
        var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
              map: resultsMap,
              position: results[0].geometry.location
            });
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDr99fcsgeUF2w1Z4lMNWcT3_xHJvOjlg&callback=initMap">
    </script>


