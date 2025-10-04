<div class="container py-5">
    <h1 class="mb-4 fw-bold">Administrácia</h1>

    <div class="list-group">
        <a href="<?= $this->Url->build(['controller' => 'Products', 'prefix' => 'Admin', 'action' => 'index']) ?>" class="list-group-item list-group-item-action">
            🛒 Produkty
        </a>
        <a href="<?= $this->Url->build(['controller' => 'Categories', 'prefix' => 'Admin', 'action' => 'index']) ?>" class="list-group-item list-group-item-action">
            🗂️ Kategórie
        </a>
        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'me', 'prefix' => false]) ?>" class="list-group-item list-group-item-action">
            👤 Môj profil
        </a>
        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout', 'prefix' => false]) ?>" class="list-group-item list-group-item-action">
            👤 Odhlásiť sa
        </a>
    </div>
</div>
