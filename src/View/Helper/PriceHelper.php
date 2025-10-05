<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;

class PriceHelper extends Helper
{
    protected float $price = 0.0;
    protected float $vatRate = 0.0;
    protected bool $isWithVat = false;

    public function display(float $price, float $vat, bool $withVat = false): self
    {
        $this->price = $price;
        $this->vatRate = $vat > 1 ? $vat / 100 : $vat;
        $this->isWithVat = $withVat;

        return $this;
    }

    public function withVat(): string
    {
        $priceWithVat = $this->isWithVat ? $this->price : $this->price * (1 + $this->vatRate);

        return $this->format($priceWithVat);
    }

    public function withoutVat(): string
    {
        $priceWithoutVat = $this->isWithVat ? $this->price / (1 + $this->vatRate) : $this->price;

        return $this->format($priceWithoutVat);
    }

    public function vat(): float
    {
        return $this->vatRate;
    }

    protected function format(float $price): string
    {
        return \number_format($price, 2, ',', ' ');
    }
}
