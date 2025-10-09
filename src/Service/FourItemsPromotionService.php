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
    private const ADD_EXTRA_QUANTITY = 0;
    private const EXTRA_ITEMS = 1;
    private const ITEMS_TRASH_HOLD = 1;

    public function isEligible(Cart $cart): bool
    {
        if (\count($cart->getItems()) >= 4) {
            return true;
        }

        return false;
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

            return $amount->sub($discountDecimal);
        });

        $newQuantity = $cheapestItem->getCartQuantity() + self::ADD_EXTRA_QUANTITY;

        if ($cheapestItem->getCartQuantity() == self::ITEMS_TRASH_HOLD) {
            $cart->setItemQuantity($cheapestItem->getCartId(), $newQuantity);
        }

        $cart->setContext(['promotionData' => new CartContext(
            $cart,
            [
                'fourItemsPromotion' => $discount,
                'fourItemsPromotionWithoutVat' => $cheapestItem->getUnitPrice(),
                'fourItemsPromotedItem' => $cheapestItem,
                'fourItemsExtraQuantity' => self::ADD_EXTRA_QUANTITY,
                'fourItemsExtraItems' => self::EXTRA_ITEMS
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
            if ($item->getCartQuantity() >= self::ITEMS_TRASH_HOLD) {
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
