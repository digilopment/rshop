<div class="container py-4">
    <h1 class="mb-5 fw-bold text-center border-bottom pb-2">
        <?= h($category->name ?? 'Produkty'); ?>
    </h1>

    <?php if (!empty($products)) { ?>
        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
            <?php foreach ($products as $product) {
                $slug = \strtolower(\Cake\Utility\Text::slug($product->name));
                $detailUrl = $this->Url->build([
                    'controller' => 'Products',
                    'action' => 'product',
                    $product->id,
                    $slug
                ]);
                ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden product-card">
                        <div class="position-relative">
                            <a href="<?= $detailUrl; ?>">
                                <img 
                                    src="<?= $this->Image->product($product->image, 'eshopProduct'); ?>" 
                                    class="card-img-top img-fluid product-img" 
                                    alt="<?= h($product->name); ?>"
                                >
                            </a>
                        </div>

                        <div class="card-body d-flex flex-column px-3 pb-3">
                            <h4 class="card-title fw-semibold text-dark text-truncate mb-2">
                                <?= h($product->name); ?>
                            </h4>

                            <div class="mt-auto">
                                <p class="mb-2">
                                    <span class="fw-bold fs-5 text-success">
                                        <?= h($this->Price->display($product->price, $product->vat)->withVat()); ?> €
                                    </span><br>
                                    <small class="text-muted">
                                        bez DPH <?= h($this->Price->display($product->price, $product->vat)->withoutVat()); ?> €
                                    </small>
                                </p>

                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="<?= $detailUrl; ?>" class="btn btn-sm btn-outline-dark px-3">
                                        Detail
                                    </a>
                                    <button 
                                        class="btn btn-sm btn-primary add-to-cart fw-semibold"
                                        data-id="<?= h($product->id); ?>"
                                        data-name="<?= h($product->name); ?>"
                                        data-price="<?= h($product->price); ?>"
                                    >
                                        <i class="bi bi-cart-plus me-1"></i> Do košíka
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div id="cart-summary" class="mt-5"></div>

    <?php } else { ?>
        <div class="alert alert-info text-center py-4 rounded-3 shadow-sm">
            V tejto kategórii momentálne nie sú žiadne produkty.
        </div>
    <?php } ?>
</div>