<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;
use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Text;

class ProductsController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
        //$this->loadModel('Products');
        $this->loadModel('Categories');
        // Prípadne načítanie ďalších komponentov, ak sú potrebné
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        // Prístup k produktom je verejný, nie je potrebné prihlasovanie
    }

    public function index($categoryId = null, $slug = null)
    {
        if ($categoryId) {
            $category = $this->Categories->get($categoryId);
            if (!$category) {
                throw new NotFoundException(__('Kategória nebola nájdená'));
            }
            $products = $this->Products->find('all')
                ->where(['category_id' => $categoryId])
                ->all();
        } else {
            $products = $this->Products->find('all')->all();
        }

        $categories = $this->Categories->find('all')->all();

        $this->set(compact('products', 'categories'));
    }

    /**
     * URL: /eshop/:id-:slug
     */
    public function category($id = null, $slug = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Kategória nebola nájdená'));
        }

        $query = $this->Products->find()
            ->contain(['Categories'])
            ->matching('Categories', function ($q) use ($id) {
                return $q->where(['Categories.id' => $id]);
            });

        $products = $query->all();
        $this->set(compact('products'));
    }

    /**
     * Detail produktu
     */
    public function view($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Produkt nebol nájdený'));
        }

        $product = $this->Products->get($id, ['contain' => ['Categories']]);
        $this->set(compact('product'));
    }

}
