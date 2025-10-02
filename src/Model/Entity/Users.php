<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;

class User extends Entity
{
    // Polia, ktoré môžu byť masívne priradené
    protected array $_accessible = [
        '*'  => true,
        'id' => false,
    ];

    // Skryté polia pri serializácii
    protected array $_hidden = [
        'password',
    ];

    /**
     * Automatické hashovanie hesla pri zápise
     *
     * @param string $password
     * @return string|null
     */
    protected function _setPassword(string $password): ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
        return null;
    }
}
