<?php
declare(strict_types=1);

namespace App\View\Helper;

use Authentication\Identity;
use Cake\View\Helper;

/**
 * Identity helper.
 *
 * Poskytuje jednoduchý prístup k prihlásenému používateľovi vo view
 */
class IdentityHelper extends Helper
{
    /**
     * Skontroluje, či je používateľ prihlásený.
     */
    public function isLoggedIn(): bool
    {
        return (bool) $this->getIdentity();
    }

    /**
     * Vráti objekt prihláseného používateľa alebo null.
     */
    public function getIdentity(): ?Identity
    {
        return $this->getView()->getRequest()->getAttribute('identity');
    }

    /**
     * Získaj hodnotu poľa prihláseného používateľa.
     *
     * @return mixed|null
     */
    public function get(string $field): mixed
    {
        $identity = $this->getIdentity();

        if ($identity) {
            return $identity->get($field);
        }

        return null;
    }
}
