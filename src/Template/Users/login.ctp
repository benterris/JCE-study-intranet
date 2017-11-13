<?= $this->Flash->render() ?>
<!--<div class="col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4 main"> 
    <div class="users form large-4 medium-4 columns content" style="text-align: center">-->
<div class="col-sm-12 col-sm-offset-2 col-md-8 col-md-offset-2 main" style="text-align: center">
         <?= $this->Form->create() ?>
        <?=$this->Html->image('logo-XXX.jpg', ['alt' => 'C\'possible logo', 'class' => 'img-thumbnail', 'align' => 'center']) ?>
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-6 vcenter">
                    <h3 class="sub-header">Déjà inscrit</h3>
                    <fieldset>
                        <legend><?= __("Entrez votre e-mail et votre mot de passe") ?></legend>
                            <?= $this->Form->input('email') ?>
                            <?= $this->Form->input('password') ?>
                    </fieldset>
                    <div class="login-button">
                        <?= $this->Form->button(__('Se Connecter')); ?>
                        <br><br>
                        <?= $this->Html->link('Mot de passe oublié', ['controller' => 'users', 'action' => 'password']); ?>
                        <br><br>
                    </div>
                </div>
                <div class="col-xs-6">
                    <h3 class="sub-header">Créer un accès</h3>
                     <?= $this->Html->link('Je veux créer un compte', ['controller' => 'users', 'action' => 'add'], ['class' => 'button']); ?>
                </div>
            </div>
        </div>
            
        
        
        

    <?= $this->Form->end() ?>
</div>
    <!--</div>
</div>-->