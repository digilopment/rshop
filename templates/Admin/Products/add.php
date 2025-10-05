<div class="container mt-4">
    <h1>Pridať nový produkt</h1>
    <?= $this->Form->create($product, ['type' => 'file']); ?>
    <?php
    if (!empty($categories)) {
        $categoriesList = [];

        foreach ($categories as $cat) {
            if (\is_object($cat) && isset($cat->id, $cat->name)) {
                $categoriesList[$cat->id] = $cat->name;
            } elseif (\is_array($cat) && isset($cat['id'], $cat['name'])) {
                $categoriesList[$cat['id']] = $cat['name'];
            } else {
                $categoriesList[$cat] = $cat;
            }
        }
    } else {
        $categoriesList = [];
    }
    ?>

    <div class="mb-3">
        <?= $this->Form->control('name', [
            'label' => 'Názov produktu',
            'class' => 'form-control'
        ]); ?>
    </div>

    <div class="mb-3">
        <?= $this->Form->control('price', [
            'label' => 'Cena',
            'class' => 'form-control'
        ]); ?>
    </div>

    <div class="mb-3">
        <?= $this->Form->control('vat', [
            'label' => 'VAT',
            'class' => 'form-control'
        ]); ?>
    </div>

    <div class="mb-3">
        <?= $this->Form->control('categories._ids', [
            'type' => 'select',
            'multiple' => true,
            'options' => $categoriesList,
            'label' => 'Kategórie',
            'class' => 'form-select'
        ]); ?>
    </div>

    <div class="mb-3">
        <?= $this->Form->control('image', [
            'type' => 'file',
            'label' => 'Obrázok produktu',
            'class' => 'form-control'
        ]); ?>
    </div>

    <?= $this->Form->button(__('Uložiť'), ['class' => 'btn btn-primary']); ?>
    <?= $this->Html->link('Späť', ['action' => 'index'], ['class' => 'btn btn-secondary ms-2']); ?>

    <?= $this->Form->end(); ?>
</div>
