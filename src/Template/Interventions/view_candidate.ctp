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
            <li><?= $this->Html->link('Accueil bénévoles', ['controller' => 'users', 'action' => 'accueil']) ?></li>
            <li><?= $this->Html->link('Mon historique', ['controller' => 'users', 'action' => 'old_interventions_volunteer']) ?></li>
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
                <th scope="row"><?= "Date demandée : " ?></th>
                <td class="view_new"><?= h($intervention['date_asked']) ?></td>
            </tr>
            <!--
            <tr>
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
               
       <?= $this->Form->postLink('<button class="btn btn-primary">Retirer ma candidature</button>', ['controller' => 'Users', 'action' => 'cancelCandidate', $intervention['id']], ['escape' => false, 'confirm' => 'Êtes-vous certain de vouloir retirer votre candidature pour cette intervention ?']) ?>
       

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

























