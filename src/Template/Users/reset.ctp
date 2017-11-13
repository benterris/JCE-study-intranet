
<div class="general-login">
    <div class="users form">
    <?= $this->Flash->render() ?>
    <?= $this->Form->create($user) ?>
        <fieldset>
            <legend> Mettre à jour le mot de passe </legend>
            <div class="body-login">
                <?= $this->Form->input('password', ['type' => 'password','required' => true, 'autofocus' => true]); ?>
                <?= $this->Form->input('confirm_password', ['type' => 'password', 'required' => true]); ?>
            </div>
        </fieldset>
        <div class="login-button">
            <?= $this->Form->button('Valider'); ?>
        </div>
    <?= $this->Form->end() ?>
    </div>
</div>
