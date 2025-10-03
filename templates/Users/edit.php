<div class="container mt-5">
    <h1 class="mb-4">Upraviť profil</h1>

    <?= $this->Form->create($user, ['class' => 'needs-validation', 'novalidate' => true]) ?>

    <div class="mb-3">
        <?= $this->Form->control('login', [
            'label' => 'Login',
            'class' => 'form-control',
            'required' => true
        ]) ?>
    </div>

    <div class="mb-3">
        <?= $this->Form->control('password', [
            'label' => 'Heslo',
            'type' => 'password',
            'class' => 'form-control',
            'autocomplete' => 'new-password',
            'required' => false,
            'placeholder' => 'Zadajte nové heslo, ak chcete zmeniť'
        ]) ?>
    </div>

    <?= $this->Form->button(__('Uložiť'), ['class' => 'btn btn-success']) ?>
    <?= $this->Html->link('Zrušiť', ['action' => 'me'], ['class' => 'btn btn-secondary ms-2']) ?>

    <?= $this->Form->end() ?>
</div>
