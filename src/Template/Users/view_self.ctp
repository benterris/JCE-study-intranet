<?= $this->Html->script('script1'); ?>

<input id="selection" type="text" value="<?= (h($user->role)) ?>">

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
            <?php if($loggedIn['role'] == 'volunteer'): ?>
                <li><?= $this->Html->link('Accueil bénévoles', ['action' => 'accueil']) ?></li>
                <li><?= $this->Html->link('Mon historique', ['action' => 'old_interventions_volunteer']) ?></li>  
            <?php elseif($loggedIn['role'] == 'highschool'): ?>
                <li><?= $this->Html->link('Accueil lycées', ['controller' => 'users', 'action' => 'accueil']) ?></li>
                <li><?= $this->Html->link('Liste des professeurs inscrits', ['controller' => 'users', 'action' => 'list_teachers_highschool']) ?></li>
                <li><?= $this->Html->link("Interventions passées", ['controller' => 'users', 'action' => 'old_interventions_highschool']) ?></li>
            <?php elseif ($loggedIn['role'] == 'teacher') : {} ?>
                <li><?= $this->Html->link('Accueil professeur', ['controller' => 'users', 'action' => 'accueil']) ?></li>
                <li><?= $this->Html->link('Demander une intervention', ['controller' => 'Interventions', 'action' => 'ask']) ?></li>
                <li><?= $this->Html->link('Mon historique', ['controller' => 'users', 'action' => 'oldInterventionsTeacher']) ?></li>
            <?php elseif ($loggedIn['role'] == 'poleManager') : {} ?>
                <li><?= $this->Html->link('Accueil', ['controller' => 'users', 'action' => 'accueil']) ?></li>
                <li><?= $this->Html->link('Interventions à valider', ['controller' => 'users', 'action' => 'toValidateInterventions']) ?></li>
                <li><?= $this->Html->link('Interventions à affecter', ['controller' => 'users', 'action' => 'toAssignInterventions']) ?></li>
                <li><?= $this->Html->link('Historique', ['controller' => 'users', 'action' => 'oldInterventionsRespoPole']) ?></li>
            <?php elseif ($loggedIn['role'] == 'admin') : {} ?>
                <li class="active"><?= $this->Html->link('Accueil', ['controller' => 'users', 'action' => 'accueil']) ?></li>
                <li><?= $this->Html->link('Liste des bénévoles', ['controller' => 'users', 'action' => 'listBenevoles']) ?></li>
                <li><?= $this->Html->link('Liste des professeurs', ['controller' => 'users', 'action' => 'listProfesseurs']) ?></li>
                <li><?= $this->Html->link('Liste des lycées', ['controller' => 'users', 'action' => 'listLycees']) ?></li>
                <li><?= $this->Html->link('Liste des responsables de pôle', ['controller' => 'users', 'action' => 'listResposPole']) ?></li>
            <?php endif; ?>
        </ul>
        
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" onload="myFunction()"> 
        <div class="col-sm-6">
        <?= $this->Flash->render() ?>
        <h1 class="page-header"><?= h($user->first_name . ' ' . $user->last_name) ?></h1>
        <div class="view_new">
        <table class="vertical-table">
            <tr>
                <th scope="row"><?= __('Statut') ?></th>
                <td><?= __(h($user->role)) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('First Name') ?></th>
                <td><?= h($user->first_name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Last Name') ?></th>
                <td><?= h($user->last_name) ?></td>
            </tr>
            <tr> 
                <th scope="row"><?= __('Address') ?></th>
                <td><?= h($user->address) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Email') ?></th>
                <td><?= h($user->email) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Phone Number') ?></th>
                <td><?= h($user->phone_number) ?></td>
            </tr>
        </table>
        </div>
            
            
            
            <div id="volunteer" class="view_new">
            <table class="vertical-table">
                <tr>
                    <th scope="row">Pôle</th>
                    <td><?= h($user->pole) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Occupation') ?></th>
                    <td><?= h($user->occupation) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Company') ?></th>
                    <td><?= h($user->company) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Birth Date') ?></th>
                    <td><?= h($user->birth_date) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Tutor') ?></th>
                    <td><?= $user->tutor ? __('Yes') : __('No'); ?></td>
                </tr>
                <!--
                <tr>
                    <th scope="row"><?= __('Membership Fee') ?></th>
                    <td><?= $user->membership_fee ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Code Ethics') ?></th>
                    <td><?= $user->code_ethics ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Disponibilités') ?></th>
                    <td><?= h($user->disponibilites); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Notes Admin') ?></th>
                    <td><?= h($user->notes_admin); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Formation') ?></th>
                    <td><?= h($user->formation); ?></td>
                </tr>
                -->
                <tr>
                    <th scope="row"><?= __('Professional Background') ?></th>
                    <td><?= h($user->professional_background); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Desired Interventions') ?></th>
                    <td><?= h($user->desired_interventions); ?></td>
                </tr>
            </table>
            </div>
            
            
            
            
            <div id="teacher" class="view_new">
                <table class="vertical-table">
                <tr>
                    <th scope="row"><?= __('Highschool name') ?></th>
                    <td><?= h($user->highschool->highschool_name); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Subject') ?></th>
                    <td><?= h($user->subject) ?></td>
                </tr>
                </table>
            </div>
            
            
            <div id="highschool" class="view_new">
                <table class="vertical-table">
                <tr>
                    <th scope="row"><?= __('First Name Delegate') ?></th>
                    <td><?= h($user->first_name_delegate) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Last Name Delegate') ?></th>
                    <td><?= h($user->last_name_delegate) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Email Delegate') ?></th>
                    <td><?= h($user->email_delegate) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Phone Number Delegate') ?></th>
                    <td><?= h($user->phone_number_delegate) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Identifiant du lycée') ?></th>
                    <td><?= $this->Number->format($user->user_id_highschool) ?></td>
                </tr>
                </table>
                </div>


                <div id="poleManager" class="view_new">
                    <table class="vertical-table">
                <tr>
                    <th scope="row">Pôle</th>
                    <td><?= h($user->poleManaged) ?></td>
                </tr>
                    </table>
            </div>
        <br><br>
        <?= $this->html->link('Modifier mes informations', '/users/edit', ['class'=>'button']) ?>
    </div>
</div>
</div>

    
        
   