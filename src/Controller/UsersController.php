<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\User;
use Authentication\Controller\Component\AuthenticationComponent;
use Cake\Event\EventInterface;
use Cake\Http\Response;

use function Cake\I18n\__;

use Cake\ORM\Table;

/**
 * @property AuthenticationComponent $Authentication
 */
class UsersController extends AppController
{
    protected Table $Users;

    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authentication.Authentication');

        $this->Users = $this->fetchTable('Users');
    }

    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
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
        $request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();

        if ($result && $result->isValid()) {
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
        $result = $this->Authentication->getResult();

        if ($result && $result->isValid()) {
            $this->Authentication->logout();
        }

        return $this->redirect(['action' => 'login']);
    }

    public function me(): ?Response
    {
        $result = $this->Authentication->getResult();
        if (!$result || !$result->isValid()) {
            return $this->redirect(['action' => 'login']);
        }

        /** @var User $userEntity */
        $userEntity = $result->getData();
        $userId     = $userEntity->id;
        $user       = $this->Users->get($userId);

        $this->set(compact('user'));
        return null;
    }

    public function edit(): ?Response
    {
        $result = $this->Authentication->getResult();
        if (!$result || !$result->isValid()) {
            return $this->redirect(['action' => 'login']);
        }

        /** @var User $userEntity */
        $userEntity = $result->getData();
        $userId     = $userEntity->id;
        $user       = $this->Users->get($userId);

        if ($this->getRequest()->is(['post', 'put', 'patch'])) {
            $user = $this->Users->patchEntity($user, $this->getRequest()->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Údaje boli uložené.'));
                return $this->redirect(['action' => 'me']);
            }
            $this->Flash->error(__('Chyba pri ukladaní údajov.'));
        }

        $this->set(compact('user'));
        return null;
    }
}
