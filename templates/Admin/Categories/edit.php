<div class="container mt-4">
    <h1>Upraviť kategóriu</h1>

    <?= $this->Form->create($category, ['type' => 'post']) ?>
        <div class="mb-3">
            <?= $this->Form->control('name', ['label' => 'Názov kategórie', 'class' => 'form-control']) ?>
        </div>

        <?= $this->Form->button(__('Uložiť'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Html->link('Späť', ['action' => 'index'], ['class' => 'btn btn-secondary ms-2']) ?>
    <?= $this->Form->end() ?>
</div>
