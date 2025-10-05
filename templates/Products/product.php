<div class="container py-5">
    <div class="row g-4 align-items-center">

        <!-- Obrázok produktu -->
        <div class="col-md-5">
            <div class="position-relative product-image-wrapper shadow-sm rounded-4 overflow-hidden">
                <img 
                    src="<?= $this->Image->product($product->image, 'eshopProduct'); ?>" 
                    alt="<?= h($product->name); ?>" 
                    class="img-fluid product-detail-img"
                >
                <span class="badge bg-primary position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill shadow-sm">
                    NOVÉ
                </span>
            </div>
        </div>

        <!-- Detail produktu -->
        <div class="col-md-7">
            <h1 class="fw-bold mb-3"><?= h($product->name); ?></h1>

            <p class="fs-4 fw-bold text-success mb-2">
                <?= h($this->Price->display($product->price, $product->vat)->withVat()); ?> €
                <small class="text-muted fs-6">bez DPH <?= h($this->Price->display($product->price, $product->vat)->withoutVat()); ?> €</small>
            </p>

            <?php if (!empty($product->categories)) { ?>
                <p class="mb-3">
                    <strong>Kategórie:</strong>
                    <?php foreach ($product->categories as $category) {
                        $slug = \strtolower(\Cake\Utility\Text::slug($category->name));
                        $url = $this->Url->build([
                            'controller' => 'Products',
                            'action' => 'category',
                            'prefix' => false,
                            $category->id,
                            $slug
                        ]);
                        ?>
                        <a href="<?= $url; ?>" class="badge bg-secondary text-decoration-none me-1 mb-1">
                            <?= h($category->name); ?>
                        </a>
                    <?php } ?>
                </p>
            <?php } ?>

            <p class="text-muted mb-4"><?= h($product->description); ?></p>

            <div class="d-flex flex-wrap gap-3">
                <button class="btn btn-lg btn-primary add-to-cart fw-semibold"
                        data-id="<?= $product->id; ?>"
                        data-name="<?= h($product->name); ?>"
                        data-price="<?= $product->price; ?>"
                        data-vat="<?= $product->vat; ?>">
                    <i class="bi bi-cart-plus me-2"></i> Do košíka
                </button>

                <a href="<?= $this->Url->build(['controller' => 'Home', 'action' => 'index', 'prefix' => false]); ?>" class="btn btn-outline-secondary btn-lg fw-semibold">
                    Späť na produkty
                </a>
            </div>
           
        </div>
    </div>
</div>