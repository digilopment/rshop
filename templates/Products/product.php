<div class="container mt-4">
    <div class="row">
        <div class="col-md-5">
            <img src="<?= $this->Image->product($product->image, 'eshopProduct') ?>" alt="<?= h($product->name) ?>" class="img-fluid rounded">
        </div>

        <div class="col-md-7">
            <h1><?= h($product->name) ?></h1>
            <p class="fs-4 fw-bold"><?= $product->price ?> € <small class="text-muted">(+<?= $product->vat ?>% DPH)</small></p>

            <?php

            use Cake\Utility\Text;

            if (!empty($product->categories)):

                ?>
                <p>
                    <strong>Kategórie:</strong>
                    <?php
                    foreach ($product->categories as $category):
                        $slug = strtolower(Text::slug($category->name));

                        ?>
                        <a href="<?=
                        $this->Url->build([
                            'controller' => 'Products',
                            'action' => 'category',
                            'prefix' => false,
                            $category->id,
                            $slug
                        ])

                        ?>" class="badge bg-secondary text-decoration-none me-1">
                               <?= h($category->name) ?>
                        </a>
                    <?php endforeach; ?>
                </p>
            <?php endif; ?>

            <p><?= h($product->description) ?></p>

            <button class="btn btn-primary add-to-cart"
                    data-id="<?= $product->id ?>"
                    data-name="<?= h($product->name) ?>"
                    data-price="<?= $product->price ?>"
                    data-vat="<?= $product->vat ?>">
                <i class="fas fa-shopping-cart me-2"></i> Pridať do košíka
            </button>

            <!-- Feedback po pridaní -->
            <div class="mt-2 add-to-cart-feedback text-success" style="display:none;">
                Produkt bol pridaný do košíka!
            </div>
        </div>
    </div>
</div>