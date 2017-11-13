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
            <li><?= $this->Html->link('Ajouter un utilisateur', ['controller' => 'users', 'action' => 'adminAdd']) ?></li>
        </ul>
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <?= $this->Flash->render() ?>
        <h1 class="page-header"><?= h($user->first_name . ' ' . $user->last_name) ?></h1>
        <div class="view_new">
        <table class="vertical-table">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($user->id) ?></td>
            </tr>
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
            <tr>
                    <th scope="row">Pôle</th>
                    <td><?= h($user->pole) ?></td>
            </tr>
            <?php
                if($user->role == 'teacher'){
                    echo '<tr><th scope="row">';
                    echo  'Nom du lycée';
                    echo '</th><td>';
                    echo $user->highschool->highschool_name;
                    echo '</td>';
                }
            ?>
            <tr>
                <th scope="row"><?= __('Occupation') ?></th>
                <td><?= h($user->occupation) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Company') ?></th>
                <td><?= h($user->company) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Subject') ?></th>
                <td><?= h($user->subject) ?></td>
            </tr>
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
            
            <tr>
                <th scope="row"><?= __('Birth Date') ?></th>
                <td><?= h($user->birth_date) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Tutor') ?></th>
                <td><?= $user->tutor ? __('Yes') : __('No'); ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Membership Fee') ?></th>
                <td><?= $user->membership_fee ? __('Yes') : __('No'); ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Code Ethics') ?></th>
                <td><?= $user->code_ethics ? __('Yes') : __('No'); ?></td>
            </tr>
        </table>
        </div>
        <div class="row">
            <h3><?= __('Professional Background') ?></h3>
        <?= $this->Text->autoParagraph(h($user->professional_background)); ?>
        </div>
        <div class="row">
            <h3><?= __('Desired Interventions') ?></h3>
        <?= $this->Text->autoParagraph(h($user->desired_interventions)); ?>
        </div>
        <div class="row">
            <h3><?= __('Disponibilités') ?></h3>
        <?= $this->Text->autoParagraph(h($user->disponibilites)); ?>
        </div>
        <!--
        <div class="row">
            <h3><?= __('Notes Admin') ?></h3>
        <?= $this->Text->autoParagraph(h($user->notes_admin)); ?>
        </div>
        -->
        <div class="row">
            <h3><?= __('Formation') ?></h3>
        <?= $this->Text->autoParagraph(h($user->formation)); ?>
        </div>
    </div>
</div>

