<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AuthController;
use Cake\Http\Exception\NotFoundException;

class CategoriesController extends AuthController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->Categories = $this->fetchTable('Categories');

        $this->getRequest()->allowMethod(['get', 'post']);
    }

    public function index()
    {
        $categories = $this->Categories->find()->all();
        $this->set(compact('categories'));
    }

    public function add()
    {
        $category = $this->Categories->newEmptyEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success('Kategória bola uložená.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Nepodarilo sa uložiť kategóriu.');
        }
        $this->set(compact('category'));
    }

    public function edit($id)
    {
        $category = $this->Categories->get($id);
        if (!$category) {
            throw new NotFoundException();
        }

        if ($this->request->is(['post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success('Kategória bola aktualizovaná.');

                $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Nepodarilo sa aktualizovať kategóriu.');
        }

        $this->set(compact('category'));
    }

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            $this->Flash->success('Kategória bola zmazaná.');
        } else {
            $this->Flash->error('Nepodarilo sa zmazať kategóriu.');
        }
        $this->redirect(['action' => 'index']);
    }

}
