<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateProducts extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('products');
        $table->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('price', 'decimal', ['precision' => 10, 'scale' => 2])
            ->addColumn('vat', 'decimal', ['precision' => 5, 'scale' => 2])
            ->addColumn('image', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->create();
    }

    public function down(): void
    {
        $this->table('products')->drop()->save();
    }
}
