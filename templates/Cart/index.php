
<div class="container py-5">
    <h1 class="mb-4">Všetky produkty</h1>

    <?php if (!empty($products)): ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($products as $product): ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="<?= $this->Image->product($product->image, 'eshopProduct') ?>" class="card-img-top" alt="<?= h($product->name) ?>">

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= h($product->name) ?></h5>
                            <p class="card-text mt-auto"><strong>Cena:</strong> <?= h($product->price) ?> €</p>
                            <a href="#" class="btn btn-primary mt-2">Kúpiť</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Momentálne nie sú žiadne produkty.</div>
    <?php endif; ?>
</div>