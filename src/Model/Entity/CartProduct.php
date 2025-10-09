<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Riesenia\Cart\CartContext;
use Riesenia\Cart\CartItemInterface;

class CartProduct implements CartItemInterface
{
    protected string $id;

    protected string $type;

    protected string $name;

    protected float $quantity;

    protected float $unitPrice;

    protected float $taxRate;

    protected ?CartContext $context = null;

    public function __construct(
        string $id,
        string $name,
        float $unitPrice,
        float $quantity = 1,
        float $taxRate = 20.0,
        string $type = 'product',
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->unitPrice = $unitPrice;
        $this->quantity = $quantity;
        $this->taxRate = $taxRate;
        $this->type = $type;
    }

    public function getCartId(): string
    {
        return $this->id;
    }

    public function getCartType(): string
    {
        return $this->type;
    }

    public function getCartName(): string
    {
        return $this->name;
    }

    public function setCartContext(CartContext $context): void
    {
        $this->context = $context;
    }

    public function setCartQuantity(float $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getCartQuantity(): float
    {
        return $this->quantity;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function getTaxRate(): float
    {
        return $this->taxRate;
    }
    
    public function getContext(): CartContext
    {
        return $this->context;
    }

}
