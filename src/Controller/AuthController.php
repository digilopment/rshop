<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\ORM\Table;

/**
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 */
class AuthController extends AppController
{
    protected Table $Categories;

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
        $this->Authentication->allowUnauthenticated([]);
    }

    public function beforeFilter(EventInterface $event): ?Response
    {
        parent::beforeFilter($event);
        $result = $this->Authentication->getResult();
        if (!$result || !$result->isValid()) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        return null;
    }
}
