<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\Table;

class HomeController extends AuthController
{
    protected Table $Products;

    protected Table $Categories;

    public function initialize(): void
    {
        parent::initialize();

        $this->Products   = $this->fetchTable('Products');
        $this->Categories = $this->fetchTable('Categories');
    }

    public function index(): void
    {
        $products   = $this->Products->find()->all()->toArray();
        $categories = $this->Categories->find()->all()->toArray();

        $this->set(compact('products', 'categories'));
    }
}
