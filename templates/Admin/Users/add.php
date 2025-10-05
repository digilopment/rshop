<h1><?= $user->isNew() ? 'Pridať užívateľa' : 'Upraviť užívateľa'; ?></h1>

<?= $this->Form->create($user, ['class' => 'needs-validation', 'novalidate' => true]); ?>
<div class="mb-3">
    <?= $this->Form->control('login', [
        'class' => 'form-control',
        'label' => 'Login',
        'placeholder' => 'Zadajte login'
    ]);

?>
</div>
<div class="mb-3">
    <?= $this->Form->control('password', [
        'class' => 'form-control',
        'label' => 'Heslo',
        'type' => 'password',
        'placeholder' => 'Zadajte heslo'
    ]);

?>
</div>
<?= $this->Form->button($user->isNew() ? 'Vytvoriť' : 'Uložiť', ['class' => 'btn btn-primary']); ?>
<a href="<?= $this->Url->build(['action' => 'index']); ?>" class="btn btn-secondary">Zrušiť</a>
<?= $this->Form->end(); ?>
