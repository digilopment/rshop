<div class="container mt-4">
    <h1>Kategórie</h1>

    <?= $this->Html->link('Pridať kategóriu', ['action' => 'add'], ['class' => 'btn btn-success mb-3']) ?>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Názov</th>
                <th>Akcie</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= h($category->id) ?></td>
                    <td><?= h($category->name) ?></td>
                    <td>
                        <?= $this->Html->link('Edit', ['action' => 'edit', $category->id], ['class' => 'btn btn-sm btn-primary']) ?>
                        <?= $this->Form->postLink('Delete', ['action' => 'delete', $category->id], [
                            'confirm' => 'Naozaj zmazať túto kategóriu?',
                            'class' => 'btn btn-sm btn-danger'
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
