<?php

declare(strict_types=1);

namespace App\Controller;

use Authentication\Controller\Component\AuthenticationComponent;
use Cake\Event\EventInterface;
use Cake\Http\Response;

use function Cake\I18n\__;

use Cake\ORM\Table;

class UsersController extends AppController
{
    protected Table $Users;

    //protected AuthenticationComponent $Authentication;

    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authentication.Authentication');

        $this->Users = $this->fetchTable('Users');
    }

    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        /** @phpstan-ignore-next-line */
        $this->Authentication->allowUnauthenticated(['login', 'register']);
    }

    public function register(): void
    {
        $user    = $this->Users->newEmptyEntity();
        $request = $this->getRequest();

        if ($request->is('post')) {
            $user = $this->Users->patchEntity($user, $request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Registrácia prebehla úspešne.'));
                $this->redirect(['action' => 'login']);
                return;
            }
            $this->Flash->error(__('Nepodarilo sa uložiť používateľa.'));
        }

        $this->set(compact('user'));
    }

    public function login(): void
    {
        $request = $this->getRequest();
        $this->getRequest()->allowMethod(['get', 'post']);
        /** @phpstan-ignore-next-line */
        $result = $this->Authentication->getResult();

        if ($result && $result->isValid()) {
            /** @phpstan-ignore-next-line */
            $target = $this->Authentication->getLoginRedirect() ?? '/';
            $this->redirect($target);
            return;
        }

        if ($request->is('post')) {
            $this->Flash->error(__('Neplatné prihlasovacie údaje.'));
        }
    }

    public function logout(): ?Response
    {
        /** @phpstan-ignore-next-line */
        $result = $this->Authentication->getResult();

        if ($result && $result->isValid()) {
            /** @phpstan-ignore-next-line */
            $this->Authentication->logout();
        }

        return $this->redirect(['action' => 'login']);
    }

}
