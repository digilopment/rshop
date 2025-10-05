<div class="container mt-4">
    <h1>Užívatelia</h1>

    <?= $this->Html->link('Pridať nového užívateľa', ['action' => 'add'], ['class' => 'btn btn-success mb-3']); ?>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Login</th>
                <th>Vytvorený</th>
                <th>Upravený</th>
                <th>Akcie</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?= h($user->id); ?></td>
                    <td><?= h($user->login); ?></td>
                    <td><?= $user->created ? $user->created->format('d.m.Y H:i') : '-'; ?></td>
                    <td><?= $user->modified ? $user->modified->format('d.m.Y H:i') : '-'; ?></td>
                    <td>
                        <?= $this->Html->link(
                            'Edit',
                            ['action' => 'edit', $user->id],
                            ['class' => 'btn btn-sm btn-primary']
                        );

                ?>

                        <?= $this->Form->postLink(
                            'Delete',
                            ['action' => 'delete', $user->id],
                            [
                                'confirm' => 'Naozaj chcete odstrániť tohto užívateľa?',
                                'class' => 'btn btn-sm btn-danger'
                            ]
                        );

                ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
