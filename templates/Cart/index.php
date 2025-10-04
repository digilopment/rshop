<?php
/**
 * @var \App\View\AppView $this
 * @var \Riesenia\Cart\CartItemInterface[] $items
 * @var float $total
 */

?>

<div class="container my-5">
    <h1 class="mb-4">Košík</h1>

    <?php if (!empty($items)): ?>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Názov</th>
                        <th>Cena</th>
                        <th>DPH</th>
                        <th>Cena s DPH</th>
                        <th>Množstvo</th>
                        <th>Akcie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <?php
                        $slug = strtolower(\Cake\Utility\Text::slug($item->getCartName()));

                        $detailUrl = $this->Url->build([
                            'controller' => 'Products',
                            'action' => 'product',
                            $item->getCartId(),
                            $slug
                            ])

                        ?>
                        <tr>
                            <td><?= h($item->getCartName()) ?></td>
                            <td><?= $item->getUnitPrice() ?> €</td>
                            <td><?= $item->getTaxRate() ?> €</td>
                            <td><?= $item->getUnitPrice() + ($item->getUnitPrice() / 100 * $item->getTaxRate()) ?> €</td>
                            <td><?= $item->getCartQuantity() ?></td>
                            <td><a href="<?= $detailUrl ?>" class="btn btn-sm btn-primary">Detail</a>
                                <button 
                                    class="btn btn-sm btn-success add-to-cart"
                                    data-id="<?= h($item->getCartId()) ?>"
                                    data-name="<?= h($item->getCartName()) ?>"
                                    data-price="<?= h($item->getUnitPrice()) ?>"
                                    data-refresh-page="true"
                                    >
                                    +1
                                </button>
                                <?=
                                $this->Html->link('Odstrániť', ['action' => 'remove', $item->getCartId()], [
                                    'class' => 'btn btn-sm btn-danger',
                                    'escape' => false
                                ])

                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <h4>Spolu: <?= $total ?>€ <br/><small><small><small>bez DPH: <?= $totalWithoutTax ?>€</small></small></small></h4>

            <div>
                <?= $this->Html->link('Pokračovať v nákupe', ['controller' => 'Products', 'action' => 'index'], ['class' => 'btn btn-primary me-2']) ?>
                <?= $this->Html->link('Vymazať košík', ['action' => 'clean'], ['class' => 'btn btn-danger']) ?>
            </div>
        </div>

    <?php else: ?>
        <div class="alert alert-info">
            Košík je prázdny.
        </div>
    <?php endif; ?>
</div>
