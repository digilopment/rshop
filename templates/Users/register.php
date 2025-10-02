<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="card-title mb-4 text-center">Registrácia používateľa</h1>

                    <?= $this->Form->create($user, ['class' => 'needs-validation', 'novalidate' => true]) ?>
                    <fieldset>
                        <legend class="mb-3">Vyplňte svoje údaje</legend>

                        <div class="mb-3">
                            <?=
                            $this->Form->control('login', [
                                'label' => 'Používateľské meno',
                                'required' => true,
                                'class' => 'form-control'
                            ])

                            ?>
                        </div>

                        <div class="mb-3">
                            <?=
                            $this->Form->control('password', [
                                'type' => 'password',
                                'label' => 'Heslo',
                                'required' => true,
                                'class' => 'form-control'
                            ])

                            ?>
                        </div>

                        <div class="mb-3">
                            <?=
                            $this->Form->control('password_confirm', [
                                'type' => 'password',
                                'label' => 'Potvrďte heslo',
                                'required' => true,
                                'class' => 'form-control'
                            ])

                            ?>
                        </div>

                        <div class="d-grid">
                            <?= $this->Form->button(__('Registrovať'), ['class' => 'btn btn-primary']) ?>
                        </div>
                    </fieldset>
                    <?= $this->Form->end() ?>

                    <p class="mt-3 text-center">
                        <?= $this->Html->link('Už máte účet? Prihlásiť sa', ['action' => 'login'], ['class' => 'text-decoration-none']) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
