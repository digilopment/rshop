<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Exception\NotFoundException;

class ProductsController extends AppController
{
    protected $Products;
    protected $Categories;

    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');

        // CakePHP 5: načítanie modelov cez fetchTable
        $this->Products = $this->fetchTable('Products');
        $this->Categories = $this->fetchTable('Categories');
    }

    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        // Prístup k produktom je verejný, nie je potrebné prihlasovanie
    }

    public function index(?int $categoryId = null, ?string $slug = null): void
    {
        if ($categoryId) {
            $category = $this->Categories->get($categoryId);
            if (!$category) {
                throw new NotFoundException(__('Kategória nebola nájdená'));
            }
            $products = $this->Products->find()
                ->where(['category_id' => $categoryId])
                ->all();
        } else {
            $products = $this->Products->find()->all();
        }

        $categories = $this->Categories->find()->all();
        $this->set(compact('products', 'categories'));
    }

    /**
     * URL: /eshop/:id-:slug
     */
    public function category(?int $id = null, ?string $slug = null): void
    {
        if (!$id) {
            throw new NotFoundException(__('Kategória nebola nájdená'));
        }

        $products = $this->Products->find()
            ->contain(['Categories'])
            ->matching('Categories', function ($q) use ($id) {
                return $q->where(['Categories.id' => $id]);
            })
            ->all();

        $this->set(compact('products'));
    }

    /**
     * Detail produktu
     */
    public function view(?int $id = null): void
    {
        if (!$id) {
            throw new NotFoundException(__('Produkt nebol nájdený'));
        }

        $product = $this->Products->get($id, ['contain' => ['Categories']]);
        $this->set(compact('product'));
    }
}
