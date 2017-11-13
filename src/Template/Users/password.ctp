<div class="general-login">
    <div class="users form">
    <?= $this->Flash->render() ?>
    <?= $this->Form->create() ?>
        <fieldset>
            <legend><?= __("Mot de passe oublié") ?></legend>
            <div class="body-login">
                <?= $this->Form->input('email', ['autofocus' => true, 'label' => 'Addresse mail', 'required' => true]); ?>
            </div>
        </fieldset>
        <div class="login-button">
            <?= $this->Form->button('Demander un changement de mot de passe'); ?>
        </div>
    <?= $this->Form->end() ?>
    </div>
</div>
