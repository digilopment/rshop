<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="card-title mb-4 text-center">Prihlásenie</h1>

                    <?= $this->Flash->render(); ?>

                    <?= $this->Form->create(null, ['class' => 'needs-validation', 'novalidate' => true]); ?>
                    <fieldset>
                        <legend class="mb-3">Zadajte svoje používateľské meno a heslo</legend>

                        <div class="mb-3">
                            <?= $this->Form->control('login', [
                                'label' => 'Používateľské meno',
                                'class' => 'form-control',
                                'required' => true
                            ]);

                    ?>
                        </div>

                        <div class="mb-3">
                            <?= $this->Form->control('password', [
                                'type' => 'password',
                                'label' => 'Heslo',
                                'class' => 'form-control',
                                'required' => true
                            ]);

                    ?>
                        </div>

                        <div class="d-grid">
                            <?= $this->Form->button(__('Prihlásiť sa'), ['class' => 'btn btn-primary']); ?>
                        </div>
                    </fieldset>
                    <?= $this->Form->end(); ?>

                    <p class="mt-3 text-center">
                        <?= $this->Html->link('Nemáte účet? Registrovať sa', ['action' => 'register'], ['class' => 'text-decoration-none']); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
