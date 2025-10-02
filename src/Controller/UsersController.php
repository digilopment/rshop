<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use function Cake\I18n\__;

class UsersController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();

        // Load authentication component
        $this->loadComponent('Authentication.Authentication');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['login', 'register']);
    }

    public function register()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Registrácia prebehla úspešne.'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('Nepodarilo sa uložiť používateľa.'));
        }
        $this->set(compact('user'));
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? '/';
            return $this->redirect($target);
        }
        if ($this->request->is('post')) {
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
