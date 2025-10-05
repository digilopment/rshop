<div class="container">
    <h1 class="mb-4">Všetky produkty</h1>

    <?php if (!empty($products)) { ?>
        <div class="row row-cols-1 row-cols-md-5 g-4">
            <?php
            foreach ($products as $product) {
                $slug = \strtolower(\Cake\Utility\Text::slug($product->name));

                $detailUrl = $this->Url->build([
                    'controller' => 'Products',
                    'action' => 'product',
                    $product->id,
                    $slug
                ]);

                ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="<?= $this->Image->product($product->image, 'eshopProduct'); ?>" class="card-img-top" alt="<?= h($product->name); ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= h($product->name); ?></h5>
                            <p class="card-text mt-auto"><strong>Cena:</strong> <?= h($product->price); ?> €</p>
                            <a href="<?= $detailUrl; ?>" class="btn btn-outline-secondary">
                                Detail
                            </a>
                            <div class="d-flex mt-2">
                                <button 
                                    class="btn btn-primary mt-2 add-to-cart d-block mx-auto"
                                    data-id="<?= h($product->id); ?>"
                                    data-name="<?= h($product->name); ?>"
                                    data-price="<?= h($product->price); ?>"
                                    >
                                    Pridať do košíka
                                </button>


                            </div>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div id="cart-summary" class="mt-4"></div>

    <?php } else { ?>
        <div class="alert alert-info">V tejto kategórii momentálne nie sú žiadne produkty.</div>
    <?php } ?>
</div>
