<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateCategories extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('categories');
        $table->addColumn('name', 'string', ['limit' => 255])
            ->create();
    }

    public function down(): void
    {
        $this->table('categories')->drop()->save();
    }
}
