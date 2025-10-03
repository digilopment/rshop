<div class="container mt-4">
    <h1>Produkty</h1>

    <?= $this->Html->link('Pridať nový produkt', ['action' => 'add'], ['class' => 'btn btn-success mb-3']) ?>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Názov</th>
                <th>Cena</th>
                <th>VAT</th>
                <th>Kategórie</th>
                <th>Akcie</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= h($product->id) ?></td>
                    <td><?= h($product->name) ?></td>
                    <td><?= h($product->price) ?></td>
                    <td><?= h($product->vat) ?></td>
                    <td>
                        <?php if (!empty($product->categories)): ?>
                            <?= implode(', ', collection($product->categories)->extract('name')->toList()) ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= $this->Html->link('Edit', ['action' => 'edit', $product->id], ['class' => 'btn btn-sm btn-primary']) ?>
                        <?= $this->Form->postLink(
                            'Delete',
                            ['action' => 'delete', $product->id],
                            ['confirm' => 'Naozaj chcete vymazať tento produkt?', 'class' => 'btn btn-sm btn-danger']
                        ) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
