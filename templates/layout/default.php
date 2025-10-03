<?php

use App\View\AppView;
use Cake\Utility\Text;

/**
 * @var AppView $this
 */
$cakeDescription = 'CakePHP: the rapid development php framework';

?>
<!DOCTYPE html>
<html lang="sk">
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $cakeDescription ?>: <?= $this->fetch('title') ?></title>
        <?= $this->Html->meta('icon') ?>

        <!-- Bootstrap 5 + custom CSS -->
        <?= $this->Html->css(['bootstrap.min', 'custom']) ?>

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>
    <body class="d-flex flex-column min-vh-100">

        <!-- Top bar -->
        <div class="bg-light py-2 border-bottom text-end px-3">
            <?php if ($this->Identity->isLoggedIn()): ?>
                Prihlásený ako 
                <strong>
                    <?=
                    $this->Html->link(
                        h($this->Identity->get('login')),
                        ['controller' => 'Users', 'action' => 'me']
                    )

                    ?>
                </strong> |
                <?= $this->Html->link('Logout', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
<?php else: ?>
    <?= $this->Html->link('Login', ['controller' => 'Users', 'action' => 'login'], ['class' => 'btn btn-sm btn-outline-primary']) ?>
<?php endif; ?>
        </div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand fw-bold" href="<?= $this->Url->build('/') ?>">R<span>SHOP</span></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCategories" aria-controls="navbarCategories" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCategories">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <?php
                        foreach ($categories as $category):
                            $slug = strtolower(Text::slug($category->name));

                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?=
                                $this->Url->build([
                                    'controller' => 'Products',
                                    'action' => 'category',
                                    $category->id,
                                    $slug
                                ])

                                ?>">
                            <?= h($category->name) ?>
                                </a>
                            </li>
<?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main content -->
        <main class="flex-fill py-4">
            <div class="container">
<?= $this->Flash->render() ?>
<?= $this->fetch('content') ?>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-light py-3 mt-auto text-center border-top">
            &copy; <?= date('Y') ?> RSHOP. All rights reserved.
        </footer>

        <!-- Bootstrap JS (optional, for navbar toggle) -->
<?= $this->Html->script(['bootstrap.bundle.min']) ?>
    </body>
</html>
