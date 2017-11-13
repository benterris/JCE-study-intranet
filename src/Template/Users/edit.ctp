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
            <li><?= $this->Html->link('Liste des utilisateurs', ['action' => 'index']) ?></li>
                    <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]
            )
        ?></li>
        </ul>
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <?= $this->Flash->render() ?>
        <div class="users form large-9 medium-8 columns content">
            
        <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Edit') ?></legend>
            <?= $this->Html->script('script1'); ?>
            <input type="text" id="selection" value="<?= $loggedIn['role'] ?>" hidden>
                
      
                
        <?php
            
            echo $this->Form->input('email');
            echo $this->Form->input('password');
            echo $this->Form->input('first_name');
            echo $this->Form->input('last_name');
            echo $this->Form->input('address');
            echo $this->Form->input('phone_number');
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
                echo $this->Form->input('pole', ['type' => 'select', 'label' => 'Pôle', 'options' => ['Entreprise' => 'Entreprise', 'Culture' => 'Culture', 'Valeurs' => 'Valeurs'], 'empty' => True]);
                
                echo $this->Form->input('company');
                echo $this->Form->input('professional_background');
                //echo $this->Form->input('desired_interventions');
                //echo $this->Form->input('disponibilites');
                //echo $this->Form->input('notes_admin');
                echo $this->Form->input('tutor');
                //echo $this->Form->input('membership_fee');
                //echo $this->Form->input('code_ethics', ['label' => "J'affirme avoir pris connaissance de la charte éthique et être en accord avec ce qu'elle contient"]);
            ?>
                    
                    
                </div>
                <div id="teacher">
            <?php
                //teachers
                echo $this->Form->input('subject');
                echo $this->Form->input('user_id_highschool', ['options' => $highschools, 'empty' => true]);
            ?>
                </div>
                <div id="highschool">
                    
            <?php
                //highschools
                echo $this->Form->input('highschool_name');
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
            
            
            
    <?= $this->Form->button(__('Enregistrer'), ['formnovalidate' => true]) ?>
    <?= $this->Form->end() ?>
            
        </div>
    </div>
</div>
