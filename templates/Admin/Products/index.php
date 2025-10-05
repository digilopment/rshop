<div class="container mt-4">
    <h1>Produkty</h1>

    <?= $this->Html->link('Pridať nový produkt', ['action' => 'add'], ['class' => 'btn btn-success mb-3']); ?>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Názov</th>
                <th>Cena bez DPH</th>
                <th>Cena s DPH</th>
                <th>Kategórie</th>
                <th>Akcie</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product) { ?>
                <?php
                $slug = \strtolower(\Cake\Utility\Text::slug($product->name));

                $detailUrl = $this->Url->build([
                    'controller' => 'Products',
                    'action' => 'product',
                    $product->id,
                    $slug,
                    'prefix' => false
                ]);

                ?>
                <tr>
                    <td><?= h($product->id); ?></td>
                    <td>
                        <a target="_blank" href="<?= $detailUrl; ?>"><?= $product->name; ?></a>
                    </td>
                    <td><?= $product->price; ?> €</td>
                    <td><?= $product->price * (1 + $product->vat / 100); ?> €</td>
                    <td>
                        <?php if (!empty($product->categories)) { ?>
                            <?php foreach ($product->categories as $cat) { ?>
                                <?php

                                $catUrl = $this->Url->build([
                                    'controller' => 'Categories',
                                    'action' => 'edit',
                                    $cat->id
                                ]);

                                ?>
                                <a href="<?= $catUrl; ?>"><?= $cat->name; ?></a>
                                <?= \end($product->categories) !== $cat ? ', ' : ''; ?>
                            <?php } ?>
                        <?php } else { ?>
                            -
                        <?php } ?>
                    </td>
                    <td>
                        <?= $this->Html->link('Edit', ['action' => 'edit', $product->id], ['class' => 'btn btn-sm btn-primary']); ?>
                        <?= $this->Form->postLink(
                            'Delete',
                            ['action' => 'delete', $product->id],
                            ['confirm' => 'Naozaj chcete vymazať tento produkt?', 'class' => 'btn btn-sm btn-danger']
                        );

                ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
