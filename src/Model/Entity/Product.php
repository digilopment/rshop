<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Product extends Entity
{
    // Polia, ktoré môžu byť masívne priradené
    protected array $_accessible = [
        '*' => true,
        'id' => false, // id nechceme aby sa prepisovalo
    ];

    /**
     * Automatické počítanie ceny s DPH
     *
     * @return float|null
     */
    protected function _getPriceWithVat(): ?float
    {
        $price = $this->get('price');
        $vat = $this->get('vat');

        if ($price === null || $vat === null) {
            return null;
        }

        return $price * (1 + $vat / 100);
    }
}
