<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class SeedSampleData extends AbstractMigration
{
    public function up(): void
    {
        $categories = [
            ['name' => 'Horské bicykle'],
            ['name' => 'Cestné bicykle'],
            ['name' => 'Mestské bicykle'],
            ['name' => 'Detské bicykle'],
            ['name' => 'Elektrobicykle']
        ];

        $this->table('categories')->insert($categories)->saveData();

        $products = [];

        for ($i = 1; $i <= 50; ++$i) {
            $products[] = [
                'name' => "Bicykel model {$i}",
                'price' => \rand(200, 3000),
                'vat' => 20.0,
                'image' => 'https://dummyimage.com/800x520/f7f7f7/111111.jpg&text=RSHOP%20' . $i,
                'created' => \date('Y-m-d H:i:s'),
                'modified' => \date('Y-m-d H:i:s')
            ];
        }

        $this->table('products')->insert($products)->saveData();

        $productsCategories = [];

        for ($productId = 1; $productId <= 50; ++$productId) {
            $catIds = [\rand(1, 5)];

            if (\rand(0, 1)) {
                $catIds[] = \rand(1, 5);
            }
            $catIds = \array_unique($catIds);

            foreach ($catIds as $catId) {
                $productsCategories[] = [
                    'product_id' => $productId,
                    'category_id' => $catId
                ];
            }
        }

        $this->table('products_categories')->insert($productsCategories)->saveData();
    }

    public function down(): void
    {
        $this->execute('DELETE FROM products_categories');
        $this->execute('DELETE FROM products');
        $this->execute('DELETE FROM categories');
    }
}
