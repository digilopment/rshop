<?php

use App\View\AppView;
use Cake\Utility\Text;

/**
 * @var AppView $this
 */
$cakeDescription = 'Rshop';

?>
<!DOCTYPE html>
<html lang="sk">
    <head>
        <?= $this->Html->charset(); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $cakeDescription; ?>: <?= $this->fetch('title'); ?></title>
        <?= $this->Html->meta('icon'); ?>

        <!-- Bootstrap 5 + cake CSS -->
        <?= $this->Html->css(['bootstrap.min', 'cake', 'custom']); ?>

        <?= $this->fetch('meta'); ?>
        <?= $this->fetch('css'); ?>
        <?= $this->fetch('script'); ?>
    </head>
    <body class="d-flex flex-column min-vh-100">

        <!-- Top bar -->
        <div class="container">
            <div class="d-flex justify-content-between align-items-center py-2 px-3 mb-3 border-bottom bg-white shadow-sm rounded">

                <div class="d-flex align-items-center gap-2 text-muted small">
                    <?php if ($this->Identity->isLoggedIn()) { ?>
                        Prihlásený ako 
                        <strong>
                            <?= $this->Html->link(
                                h($this->Identity->get('login')),
                                ['controller' => 'Users', 'action' => 'me', 'prefix' => false],
                                ['class' => 'text-dark text-decoration-none']
                            );

                        ?>
                        </strong>
                        <span class="mx-1">|</span>
                        <?= $this->Html->link(
                            'Odhlásiť',
                            ['controller' => 'Users', 'action' => 'logout', 'prefix' => false],
                            ['class' => 'text-decoration-none text-danger']
                        );

                        ?>
                    <?php } ?>
                </div>

                <div>
                    <?php if ($this->Identity->isLoggedIn()) { ?>
                        <?= $this->Html->link(
                            'Admin',
                            ['prefix' => 'Admin', 'controller' => 'Home', 'action' => 'index'],
                            ['class' => 'btn btn-sm btn-outline-primary']
                        );

                        ?>
                    <?php } else { ?>
                        <?= $this->Html->link(
                            'Login',
                            ['controller' => 'Users', 'action' => 'login', 'prefix' => false],
                            ['class' => 'btn btn-sm btn-outline-primary']
                        );

                        ?>
                        <?= $this->Html->link(
                            'Registrácia',
                            ['controller' => 'Users', 'action' => 'register', 'prefix' => false],
                            ['class' => 'btn btn-sm btn-outline-primary']
                        );

                        ?>
                    <?php } ?>
                </div>

            </div>
        </div>



        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand fw-bold" href="<?= $this->Url->build('/'); ?>">R<span>SHOP</span></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCategories" aria-controls="navbarCategories" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCategories">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <?php
                        $currentController = $this->request->getParam('controller');
$currentAction = $this->request->getParam('action');
$currentCategoryId = $this->request->getParam('pass')[0] ?? null;

foreach ($categories as $category) {
    $slug = \strtolower(Text::slug($category->name));
    $isActive = ($currentController === 'Products' && $currentAction === 'category' && $currentCategoryId == $category->id) ? 'active' : '';

    ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $isActive; ?>" href="<?= $this->Url->build([
                                    'controller' => 'Products',
                                    'action' => 'category',
                                    'prefix' => false,
                                    $category->id,
                                    $slug
                                ]);

    ?>">
                                       <?= h($category->name); ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>


                    <a href="<?= $this->Url->build(['controller' => 'Cart', 'action' => 'index', 'prefix' => false]); ?>" class="text-decoration-none">
                        <div class="cart-summary d-flex align-items-center ms-lg-4 text-white">
                            <i class="fas fa-shopping-cart me-2"></i>
                            <span class="cart-info">🛒
                                <span class="cart-total fw-bold"><?= h($this->Price->display($total, false, true)->withVat()); ?> €</span>
                                <small class="cart-count ms-1">(<?= \count($items); ?> položiek)</small>
                            </span>
                        </div>
                    </a>

                </div>
            </div>
        </nav>

        <!-- Main content -->
        <main class="flex-fill py-4">
            <div class="container">
                <?= $this->Flash->render(); ?>
                <?= $this->fetch('content'); ?>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-light py-3 mt-auto text-center border-top">
            &copy; <?= \date('Y'); ?> RSHOP. All rights reserved.
        </footer>

        <!-- Bootstrap JS (optional, for navbar toggle) -->
        <?= $this->Html->script(['jquery/jquery-3.6.0.min']); ?>
        <?= $this->Html->script(['bootstrap/bootstrap.min']); ?>
        <?= $this->Html->script(['main']); ?>
    </body>
</html>
