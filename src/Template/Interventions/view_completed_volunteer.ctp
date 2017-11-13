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
            <?php if($loggedIn['role'] == 'highschool'): ?>
                <li><?= $this->Html->link('Accueil lycées', ['controller' => 'users', 'action' => 'accueil']) ?></li>
                <li><?= $this->Html->link('Liste des professeurs inscrits', ['controller' => 'users', 'action' => 'list_teachers_highschool']) ?></li>
                <li><?= $this->Html->link("Interventions passées", ['controller' => 'users', 'action' => 'old_interventions_highschool']) ?></li>
            <?php elseif ($loggedIn['role'] == 'teacher') : {} ?>
                <li><?= $this->Html->link('Accueil professeur', ['controller' => 'users', 'action' => 'accueil']) ?></li>
                <li><?= $this->Html->link('Demander une intervention', ['controller' => 'Interventions', 'action' => 'ask']) ?></li>
                <li><?= $this->Html->link('Mon historique', ['controller' => 'users', 'action' => 'oldInterventionsTeacher']) ?></li>
            <?php elseif ($loggedIn['role'] == 'poleManager') : {} ?>
                <li class="active"><?= $this->Html->link('Accueil Responsable de Pôle', ['action' => 'accueil']) ?></li>
            <li><?= $this->Html->link('Interventions à valider', ['action' => 'toValidateInterventions']) ?></li>
            <li><?= $this->Html->link('Interventions à affecter', ['action' => 'toAssignInterventions']) ?></li>
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
                <th scope="row"><?= "Date : " ?></th>
                <td class="view_new"><?= h($intervention->date) ?></td>
            </tr>
            <!--<tr>
                <th scope="row"><?= "Durée : " ?></th>
                <td class="view_new"><?= h($intervention->length_intervention) ?></td>
            </tr>-->
            <tr>
                <th scope="row"><?= "Pôle : " ?></th>
                <td class="view_new"><?= h($intervention->pole) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= "Nom du professeur : " ?></th>
                <td class="view_new"><?= h($intervention->teacher->first_name) . " " . h($intervention->teacher->last_name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= "Classe : " ?></th>
                <td class="view_new"><?= h($intervention->section_name)?></td>
            </tr>
            <tr>
                <th scope="row"><?= "Description de l'intervention : " ?></th>
                <td class="view_new"><?= h($intervention->type_intervention) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= "Détails : " ?></th>
                <td class="view_new"><?= h($intervention->comment) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= 'Nom du lycée : ' ?></th>
                <td class="view_new"><?= h($intervention->teacher->highschool->highschool_name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= "Adresse de l'établissement : " ?></th>
                <td class="view_new"><?= h($intervention->teacher->highschool->address) ?></td>
            </tr>
        </table>
                <?= $this->Form->create($intervention) ?>
                <?= $this->Form->input('feedback_intervenant', ['label' => 'Mon commentaire sur cette intervention']);?>
                <?= $this->Form->button(__('Enregistrer mon commentaire'), ['formnovalidate' => true]) ?>
                <?= $this->Form->end() ?>
        
            </div>
            <div class="col-sm-6">
                <div id="map"></div>
            </div>
        </div>
        
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


