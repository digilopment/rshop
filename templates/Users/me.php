<div class="container mt-5">
    <h1 class="mb-4">Môj profil</h1>

    <div class="card">
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th scope="row">Login:</th>
                    <td><?= h($user->login) ?></td>
                </tr>
                <tr>
                    <th scope="row">Vytvorené:</th>
                    <td><?= h($user->created) ?></td>
                </tr>
                <tr>
                    <th scope="row">Upravené:</th>
                    <td><?= h($user->modified) ?></td>
                </tr>
            </table>

            <a href="<?= $this->Url->build(['action' => 'edit']) ?>" class="btn btn-primary mt-3">Upraviť profil</a>
        </div>
    </div>
</div>
