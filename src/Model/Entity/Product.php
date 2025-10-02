<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Product extends Entity
{
    // Polia, ktoré môžu byť masívne priradené
    protected $_accessible = [
        '*' => true,
        'id' => false, // id nechceme aby sa prepisovalo
    ];

    // Automatické počítanie ceny s DPH
    protected function _getPriceWithVat(): ?float
    {
        if (!isset($this->price) || !isset($this->vat)) {
            return null;
        }
        return $this->price * (1 + $this->vat / 100);
    }
}
