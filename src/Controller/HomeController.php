<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class HomeController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Products');
        $this->loadModel('Categories');
    }

    public function index()
    {
        $products = $this->Products->find('all')->toArray();

        $categories = $this->Categories->find('all')->toArray();

        $this->set(compact('products', 'categories'));
    }

}
