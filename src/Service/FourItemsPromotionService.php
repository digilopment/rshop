<?php
declare(strict_types=1);

namespace App\Service;

use Litipk\BigNumbers\Decimal;
use Riesenia\Cart\Cart;
use Riesenia\Cart\CartContext;
use Riesenia\Cart\CartItemInterface;
use Riesenia\Cart\PromotionInterface;


class FourItemsPromotionService implements PromotionInterface
{

    private const EXTRA_ITEMS = 1;
    
    public function isEligible(Cart $cart): bool
    {
        $cheapest = $this->cheapsetPromotedItem($cart);
        return $cheapest !== null;
    }

    public function beforeApply(Cart $cart): void
    {
        
    }

    public function apply(Cart $cart): void
    {
        $cheapestItem = $this->cheapsetPromotedItem($cart);
        if (!$cheapestItem) {
            return;
        }

        $discount = $cheapestItem->getUnitPrice() / 100 * (100 + $cheapestItem->getTaxRate());
        $cart->setTotalRounding(function ($amount) use ($discount) {
            if (!$amount instanceof Decimal) {
                $amount = Decimal::fromFloat((float) $amount);
            }
            $discountDecimal = Decimal::fromFloat((float) $discount);
            $newTotal = $amount->sub($discountDecimal);

            return $newTotal->isNegative() ? Decimal::fromFloat(0.0) : $newTotal;
        });

        $newQuantity = $cheapestItem->getCartQuantity() + self::EXTRA_ITEMS;
        $cart->setItemQuantity($cheapestItem->getCartId(), $newQuantity);

        $cart->setContext(['promotionData' => new CartContext(
                $cart,
                [
                'fourItemsPromotion' => $discount,
                'fourItemsPromotedItem' => $cheapestItem,
                'fourItemsExtraItems' => self::EXTRA_ITEMS,
                ]
        )]);
    }

    public function afterApply(Cart $cart): void
    {
        
    }

    private function cheapsetPromotedItem(Cart $cart): ?CartItemInterface
    {
        $cheapestItem = null;
        $minPrice = PHP_FLOAT_MAX;

        foreach ($cart->getItems() as $item) {
            if ($item->getCartQuantity() >= 4) {
                $price = $item->getUnitPrice();

                if ($price < $minPrice) {
                    $minPrice = $price;
                    $cheapestItem = $item;
                }
            }
        }

        return $cheapestItem;
    }

}
