<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use function Cake\I18n\__;

class UsersController extends AppController
{
    protected $Users;

    public function initialize(): void
    {
        parent::initialize();

        // Load authentication component
        $this->loadComponent('Authentication.Authentication');

        // CakePHP 5: načítanie modelu cez fetchTable
        $this->Users = $this->fetchTable('Users');
    }

    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['login', 'register']);
    }

    public function register(): void
    {
        $user = $this->Users->newEmptyEntity();
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
        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? '/';
            $this->redirect($target);
            return;
        }

        if ($request->is('post')) {
            $this->Flash->error(__('Neplatné prihlasovacie údaje.'));
        }
    }

    public function logout()
    {
        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            $this->Authentication->logout();
        }

        return $this->redirect(['action' => 'login']);
    }
}
