<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AuthController;

/**
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AuthController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    public function index(): void
    {
        $users = $this->Users->find();
        $this->set(\compact('users'));
    }

    public function add(): void
    {
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success(__('User bol úspešne vytvorený.'));
                $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Nepodarilo sa uložiť usera.'));
            }
        }
        $this->set(\compact('user'));
    }

    public function edit(int $id): void
    {
        $user = $this->Users->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success(__('User bol úspešne upravený.'));
                $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Nepodarilo sa uložiť usera.'));
            }
        }
        $this->set(\compact('user'));
    }

    public function delete(int $id): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);

        if ($this->Users->delete($user)) {
            $this->Flash->success(__('User bol odstránený.'));
        } else {
            $this->Flash->error(__('Nepodarilo sa odstrániť usera.'));
        }
        $this->redirect(['action' => 'index']);
    }
}
