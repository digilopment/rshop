<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class HomeController extends AppController
{
    protected $Products;
    protected $Categories;

    public function initialize(): void
    {
        parent::initialize();

        // CakePHP 5: načítanie modelov cez fetchTable
        $this->Products = $this->fetchTable('Products');
        $this->Categories = $this->fetchTable('Categories');
    }

    public function index(): void
    {
        $products = $this->Products->find()->all()->toArray();
        $categories = $this->Categories->find()->all()->toArray();

        $this->set(compact('products', 'categories'));
    }
}
