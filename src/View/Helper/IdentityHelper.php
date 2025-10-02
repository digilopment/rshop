<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;

/**
 * Identity helper
 *
 * Poskytuje jednoduchý prístup k prihlásenému používateľovi vo view
 */
class IdentityHelper extends Helper
{
    /**
     * Skontroluje, či je používateľ prihlásený
     *
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return (bool)$this->getIdentity();
    }

    /**
     * Vráti objekt prihláseného používateľa alebo null
     *
     * @return \Authentication\Identity|null
     */
    public function getIdentity()
    {
        return $this->getView()->getRequest()->getAttribute('identity');
    }

    /**
     * Získaj hodnotu poľa prihláseného používateľa
     *
     * @param string $field
     * @return mixed|null
     */
    public function get(string $field)
    {
        $identity = $this->getIdentity();
        if ($identity) {
            return $identity->get($field);
        }
        return null;
    }
}
