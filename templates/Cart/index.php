<div class="container py-5">
    <h1 class="mb-4 text-center fw-bold">Košík</h1>

    <?php if (!empty($items)) { ?>
        <div class="table-responsive shadow-sm rounded-4 overflow-hidden">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Názov</th>
                        <th>Cena / ks / bez DPH</th>
                        <th>DPH</th>
                        <th>Celková cena s DPH</th>
                        <th>Množstvo</th>
                        <th>Akcie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($items as $item) {
                        $slug = \strtolower(\Cake\Utility\Text::slug($item->getCartName()));
                        $detailUrl = $this->Url->build([
                            'controller' => 'Products',
                            'action' => 'product',
                            $item->getCartId(),
                            $slug
                        ]);

                        $unitPriceWithVat = $item->getUnitPrice() + ($item->getUnitPrice() / 100 * $item->getTaxRate());
                        $totalPriceWithVat = $unitPriceWithVat * $item->getCartQuantity();

                        ?>
                        <tr class="align-middle">
                            <td>
                                <a href="<?= $detailUrl; ?>" class="text-decoration-none fw-semibold text-dark">
                                    <?= h($item->getCartName()); ?>
                                </a>
                            </td>
                            <td><?= \number_format($item->getUnitPrice(), 2, ',', ' '); ?> €</td>
                            <td><?= $item->getTaxRate(); ?> %</td>
                            <td class="fw-bold text-success"><?= \number_format($totalPriceWithVat, 2, ',', ' '); ?> €</td>
                            <td>
                                <span class="badge bg-primary fs-6"><?= $item->getCartQuantity(); ?></span>
                            </td>
                            <td class="d-flex gap-1 flex-wrap">
                                <a href="<?= $detailUrl; ?>" class="btn btn-sm btn-outline-dark">
                                    <i class="bi bi-info-circle"></i> Produkt
                                </a>
                                <button 
                                    class="btn btn-sm btn-success add-to-cart"
                                    data-id="<?= h($item->getCartId()); ?>"
                                    data-name="<?= h($item->getCartName()); ?>"
                                    data-price="<?= h($item->getUnitPrice()); ?>"
                                    data-refresh-page="true"
                                    >
                                    +1
                                </button>
                                <?= $this->Html->link('<i class="bi bi-trash"></i> Odstrániť', ['action' => 'remove', $item->getCartId()], [
                                    'class' => 'btn btn-sm btn-danger',
                                    'escape' => false
                                ]);

                        ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 gap-3">
            <div class="fs-5 fw-bold">
                Spolu: <span class="text-success"><?= \number_format($total, 2, ',', ' '); ?> €</span><br>
                <small class="text-muted">bez DPH: <?= \number_format($totalWithoutTax, 2, ',', ' '); ?> €</small>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <?= $this->Html->link('Pokračovať v nákupe', ['controller' => 'Home', 'action' => 'index'], ['class' => 'btn btn-primary fw-semibold']); ?>
                <?= $this->Html->link('Vymazať košík', ['action' => 'clean'], ['class' => 'btn btn-outline-danger fw-semibold']); ?>
                <?= $this->Html->link('Prejsť k objednávke', ['controller' => 'Orders', 'action' => 'checkout'], ['class' => 'btn btn-success fw-semibold']); ?>
            </div>
        </div>

    <?php } else { ?>
        <div class="alert alert-info text-center py-4 shadow-sm rounded-3">
            Košík je prázdny.
        </div>
    <?php } ?>
</div>