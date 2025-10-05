<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\CartService;
use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use Cake\Http\Session;
use Cake\ORM\Table;

class AppController extends Controller
{
    protected Table $Categories;

    protected CartService $cartService;

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->Categories  = $this->fetchTable('Categories');
        $this->cartService = new CartService(new Session());
    }

    public function beforeRender(EventInterface $event): void
    {
        parent::beforeRender($event);
        $categories      = $this->Categories->find()->all()->toArray();
        $items           = $this->cartService->all();
        $total           = $this->cartService->cart->getTotal()->asFloat();
        $totalWithoutTax = $this->cartService->cart->getSubtotal()->asFloat();

        $this->set(compact('categories', 'items', 'total', 'totalWithoutTax'));
    }
}
