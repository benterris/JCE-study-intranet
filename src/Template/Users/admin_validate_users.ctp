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
            <li class="active"><?= $this->Html->link('Comptes en attente de validation', ['controller' => 'users', 'action' => 'adminValidateUsers']) ?></li>
            <li><?= $this->Html->link('Ajouter un utilisateur', ['controller' => 'users', 'action' => 'adminAdd']) ?></li>
            <li><?= $this->Html->link('Interventions à valider', ['controller' => 'users', 'action' => 'toValidateInterventions']) ?></li>
            <li><?= $this->Html->link('Interventions à affecter', ['controller' => 'users', 'action' => 'toAssignInterventions']) ?></li>
            
        </ul>
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <?= $this->Flash->render() ?>
        <h1 class="page-header">Liste des demandes de création de compte</h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('role') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('first_name') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('last_name') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('address') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('phone_number') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('birth_date') ?></th>
                    </tr>
                </thead>
                <tbody>
            <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $this->Number->format($user->id) ?></td>
                        <td><?= h($user->role) ?></td>
                        <td><?= h($user->first_name) ?></td>
                        <td><?= h($user->last_name) ?></td>
                        <td><?= h($user->address) ?></td>
                        <td><?= h($user->email) ?></td>
                        <td><?= h($user->phone_number) ?></td>
                        <td><?= h($user->birth_date) ?></td>
                        <td class="actions">
                    <?= $this->Form->postLink('Valider', ['controller' => 'Users', 'action' => 'validateUser', $user->id], ['confirm' => __("Êtes-vous certain de vouloir valider la création de ce compte ?", $user->id)]) ?>
                    <?= $this->Form->postLink('Refuser', ['controller' => 'Users', 'action' => 'delete', $user->id], ['confirm' => __("Refuser cette demande d'ajout de compte supprimera le compte correspondant. Êtes-vous certain de vouloir supprimer ce compte ?", $user->id)]) ?>
                    <?= $this->Html->link('Détails', ['controller' => 'Users', 'action' => 'viewUserAdmin', $user->id]) ?>
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
    
