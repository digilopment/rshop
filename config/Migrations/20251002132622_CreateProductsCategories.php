<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateProductsCategories extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('products_categories', ['id' => false, 'primary_key' => ['product_id', 'category_id']]);
        $table->addColumn('product_id', 'integer')
              ->addColumn('category_id', 'integer')
              ->addForeignKey('product_id', 'products', 'id', ['delete'=> 'CASCADE'])
              ->addForeignKey('category_id', 'categories', 'id', ['delete'=> 'CASCADE'])
              ->create();
    }

    public function down(): void
    {
        $this->table('products_categories')->drop()->save();
    }
}
