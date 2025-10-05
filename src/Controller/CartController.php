<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\CartService;

class CartController extends AuthController
{
    protected CartService $cartService;

    public function initialize(): void
    {
        parent::initialize();
        $this->cartService = new CartService($this->getRequest()->getSession());
    }

    public function index(): void
    {
        $this->set('items', $this->cartService->all());
        $this->set('total', $this->cartService->cart->getTotal()->asFloat());
        $this->set('totalWithoutTax', $this->cartService->cart->getSubtotal()->asFloat());
    }

    public function clean(): void
    {
        $this->cartService->clean();
        $this->redirect(['action' => 'index']);
    }

    public function remove(string $id): void
    {
        $this->cartService->remove($id);
        $this->redirect(['action' => 'index']);
    }
}
