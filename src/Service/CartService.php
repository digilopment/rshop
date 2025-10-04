<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Entity\CartProduct;
use Cake\Http\Session;
use Riesenia\Cart\Cart;

class CartService
{
    public Cart $cart;
    private Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
        $storedCart    = json_decode(json_encode($this->session->read('Cart'))) ?? [];
        $this->cart    = new Cart();
        $this->cart->setPricesWithVat(false);

        foreach ($storedCart as $item) {
            $cartItem = new CartProduct(
                $item->id,
                $item->name,
                $item->unitPrice,
                $item->quantity,
                $item->taxRate,
                $item->type
            );
            $this->cart->addItem($cartItem);
            $this->cart->setItemQuantity($item->id, $item->quantity);
        }
        $this->cart->getItems();
    }

    public function add(string $id, string $name, float $unitPrice, float $quantity = 1, float $taxRate = 20.0, string $type = 'product'): void
    {

        $existingProductCartQuantity = 0;
        foreach ($this->cart->getItems() as $item) {
            if ($item->getCartId() == $id) {
                $existingProductCartQuantity = $item->getCartQuantity();
            }
        }
        $newQuantity = $quantity + $existingProductCartQuantity;
        if ($existingProductCartQuantity > 0) {
            $this->cart->setItemQuantity($id, $newQuantity);
        } else {
            $cartItem = new CartProduct(
                $id,
                $name,
                $unitPrice,
                $quantity,
                $taxRate,
                $type
            );
            $this->cart->addItem($cartItem);
        }
        $this->persist();
    }

    public function clean(): void
    {
        $this->cart = new Cart();
        $this->persist();
    }

    public function remove(string $id): void
    {
        $this->cart->removeItem($id);
        $this->persist();
    }

    public function all(): array
    {
        return $this->cart->getItems();
    }

    private function persist(): void
    {
        $items = [];
        foreach ($this->cart->getItems() as $item) {
            $items[$item->getCartId()] = [
                'id'        => $item->getCartId(),
                'name'      => $item->getCartName(),
                'unitPrice' => $item->getUnitPrice(),
                'quantity'  => $item->getCartQuantity(),
                'taxRate'   => $item->getTaxRate(),
                'type'      => $item->getCartType(),
            ];
        }
        $this->session->write('Cart', $items);
    }

}
