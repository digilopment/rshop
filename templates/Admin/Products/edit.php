<div class="container mt-4">
    <h1>Upraviť produkt</h1>

    <?php
    if (!empty($categories)) {
        $categoriesList = [];
        foreach ($categories as $cat) {
            if (is_object($cat) && isset($cat->id, $cat->name)) {
                $categoriesList[$cat->id] = $cat->name;
            } elseif (is_array($cat) && isset($cat['id'], $cat['name'])) {
                $categoriesList[$cat['id']] = $cat['name'];
            } else {
                $categoriesList[$cat] = $cat;
            }
        }
    } else {
        $categoriesList = [];
    }
    ?>

    <?= $this->Form->create($product, ['type' => 'file']) ?>

        <div class="mb-3">
            <?= $this->Form->control('name', [
                'label' => 'Názov produktu',
                'class' => 'form-control'
            ]) ?>
        </div>

        <div class="mb-3">
            <?= $this->Form->control('price', [
                'label' => 'Cena',
                'class' => 'form-control'
            ]) ?>
        </div>

        <div class="mb-3">
            <?= $this->Form->control('vat', [
                'label' => 'VAT',
                'class' => 'form-control'
            ]) ?>
        </div>

        <div class="mb-3">
            <?= $this->Form->control('categories._ids', [
                'type' => 'select',
                'multiple' => true,
                'options' => $categoriesList,
                'label' => 'Kategórie',
                'class' => 'form-select'
            ]) ?>
        </div>

        <div class="mb-3">
            <?= $this->Form->control('image', [
                'type' => 'file',
                'label' => 'Obrázok produktu',
                'class' => 'form-control'
            ]) ?>

            <?php if (!empty($product->image)): ?>
                <div class="mt-2">
                    <p>Aktuálny obrázok:</p>
                    <img src="<?= $this->Image->product($product->image, 'eshopProduct') ?>" alt="Produktový obrázok" style="max-width: 300px; height: auto;">
                </div>
            <?php endif; ?>
        </div>

        <?= $this->Form->button(__('Uložiť'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Html->link('Späť', ['prefix' => 'Admin', 'controller' => 'Products', 'action' => 'index'], ['class' => 'btn btn-secondary ms-2']) ?>

    <?= $this->Form->end() ?>
</div>
