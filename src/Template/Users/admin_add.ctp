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
            <li><?= $this->Html->link('Accueil', ['controller' => 'users', 'action' => 'accueil']) ?></li>
            <li><?= $this->Html->link('Liste des bénévoles', ['controller' => 'users', 'action' => 'listBenevoles']) ?></li>
            <li><?= $this->Html->link('Liste des professeurs', ['controller' => 'users', 'action' => 'listProfesseurs']) ?></li>
            <li><?= $this->Html->link('Liste des lycées', ['controller' => 'users', 'action' => 'listLycees']) ?></li>
            <li><?= $this->Html->link('Liste des responsables de pôle', ['controller' => 'users', 'action' => 'listResposPole']) ?></li>
            <li><?= $this->Html->link('Comptes en attente de validation', ['controller' => 'users', 'action' => 'adminValidateUsers']) ?></li>
            <li class="active"><?= $this->Html->link('Ajouter un utilisateur', ['controller' => 'users', 'action' => 'adminAdd']) ?></li>
            <li><?= $this->Html->link('Interventions à valider', ['controller' => 'users', 'action' => 'toValidateInterventions']) ?></li>
            <li><?= $this->Html->link('Interventions à affecter', ['controller' => 'users', 'action' => 'toAssignInterventions']) ?></li>
        </ul>
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <?= $this->Flash->render() ?>
        <div class="users form large-9 medium-8 columns content">
            
        <?= $this->Form->create($user) ?>
            
            <!-- <div class="g-recaptcha" data-sitekey="6LfnVyEUAAAAAPdGVBglfbV9MtuRnN0ZeBhRuNyO"></div> -->
            
            <fieldset>
                <legend>Créer un compte</legend>
            <?= $this->Html->script('scriptAdd'); ?>
            <div class="form-group">
            <label for="selection">Statut *</label>
            <?= $this->Form->select('role', ['volunteer' => 'Bénévole', 'teacher' => 'Professeur', 'highschool' => 'Lycée', 'poleManager' => 'Responsable de pôle'], ['onchange' => 'myFunction()', 'id' => 'selection', 'empty' => true]); ?>
            </div>
                
        <?php
            
            echo $this->Form->input('last_name', ['label' => 'Nom *']);
            echo $this->Form->input('first_name', ['label' => 'Prénom *']);
            echo $this->Form->input('email', ['label' => 'Email *']);
            echo $this->Form->input('password', ['label' => 'Mot de passe *']);
            echo $this->Form->input('address', ['label' => 'Adresse *']);
            echo $this->Form->input('phone_number', ['label' => 'Téléphone *']);
        ?>
                
                <div id="volunteer">
            <?php
                //volunteers
                echo '<div class="form-group">';
                echo '<label for="birth-date[day]">Date de naissance</label>';
                echo '<div class="form-inline">';
                echo '<row>';
                echo $this->Form->input('birth_date', [
                    'label' => false,
                    'empty' => true, 
                    'hour' => false, 
                    'minute' => false, 
                    'minYear' => date('Y') - 90, 
                    'maxYear' => date('Y') - 12, 
                    'interval' => 5,
                    'year' => [
                        'class' => 'form-control col-md-4'
                    ],
                    'month' => [
                        'class' => 'form-control col-md-4'
                    ],
                    'day' => [
                        'class' => 'form-control col-md-4'
                    ]
                ]);
                echo '</div></row></div>';
                echo $this->Form->input('occupation');
                //echo '<div class="form-group">';
                //echo '<label for="pole">Pôle</label>';
                //echo $this->Form->select('pole', ['Entreprise' => 'Entreprise', 'Culture' => 'Culture', 'Valeurs' => 'Valeurs'], ['empty' => true]);
                //echo "</div>";
                echo $this->Form->input('pole', ['type' => 'select', 'label' => 'Pôle *', 'options' => ['Entreprise' => 'Entreprise', 'Culture' => 'Culture', 'Valeurs' => 'Valeurs'], 'empty' => True]);
                
                echo $this->Form->input('company', ['label' => 'Entreprise / Etablissement']);
                echo $this->Form->input('professional_background', ['label' => 'Expérience professionnelle']);
                echo $this->Form->input('desired_interventions', ['label' => 'Interventions souhaitées']);
                //echo $this->Form->input('disponibilites');
                //echo $this->Form->input('notes_admin');
                echo $this->Form->input('tutor', ['label' => "J'aimerais devenir tuteur"]);
                //echo $this->Form->input('membership_fee');
                //echo $this->Form->input('code_ethics', ['label' => "J'affirme avoir pris connaissance de la charte éthique et être en accord avec ce qu'elle contient"]);
            ?>
                    
                    
                </div>
                <div id="teacher">
            <?php
                //teachers
                echo $this->Form->input('subject');
                echo $this->Form->input('user_id_highschool', ['options' => $highschools, 'empty' => true, 'label' => 'Lycée *']);
            ?>
                </div>
                <div id="highschool">
                    
            <?php
                //highschools
                echo $this->Form->input('highschool_name', ['label' => "Nom du lycée *"]);
                echo $this->Form->input('first_name_delegate');
                echo $this->Form->input('last_name_delegate');
                echo $this->Form->input('email_delegate');
                echo $this->Form->input('phone_number_delegate');
                echo $this->Form->input('formation');
            ?>
                </div>
                <div id="poleManager">
            <?php
                //pole manager
                echo '<div class="form-group">';
                echo '<label for="pole">Pôle</label>';
                echo $this->Form->select('poleManaged', ['Entreprise' => 'Entreprise', 'Culture' => 'Culture', 'Valeurs' => 'Valeurs'], ['empty' => true]);
                echo '</div>';
                ?>
                </div>
                
            </fieldset>
            
        <!--<div class="g-recaptcha" data-sitekey="6LfnVyEUAAAAAPdGVBglfbV9MtuRnN0ZeBhRuNyO"></div>-->
        <br>
    <?= $this->Form->button(__('Enregistrer'), ['formnovalidate' => true]); ?>
    <?= $this->Form->end() ?>
            
            
        </div>
    </div>
</div>
