<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

use function Cake\I18n\__;

use Cake\ORM\Table;

class ProductsController extends AuthController
{
    protected Table $Products;
    protected Table $Categories;

    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');

        $this->Products   = $this->fetchTable('Products');
        $this->Categories = $this->fetchTable('Categories');
    }

    public function index(?int $categoryId = null, ?string $slug = null): void
    {
        if ($categoryId) {

            $products = $this->Products->find()
                ->where(['category_id' => $categoryId])
                ->all();
        } else {
            $products = $this->Products->find()->all();
        }

        $categories = $this->Categories->find()->all();
        $this->set(compact('products', 'categories'));
    }

    public function category(?int $id = null, ?string $slug = null): void
    {
        $query = $this->Products->find()
            ->contain(['Categories']);
        if ($id) {
            $query = $query->matching('Categories', function ($q) use ($id) {
                return $q->where(['Categories.id' => $id]);
            });
            $category = $this->Categories->get($id);
        } else {
            $category = null;
        }
        $products = $query->all();

        $this->set(compact('products', 'category'));
    }

    public function product(?int $id = null): void
    {
        if (!$id) {
            throw new NotFoundException(__('Produkt nebol nájdený'));
        }

        $product = $this->Products->get($id, ['contain' => ['Categories']]);
        $this->set(compact('product'));
    }

}
