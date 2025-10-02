<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use Cake\ORM\Table;

class AppController extends Controller
{
    protected Table $Categories;

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->Categories = $this->fetchTable('Categories');
    }

    public function beforeRender(EventInterface $event): void
    {
        parent::beforeRender($event);
        $categories = $this->Categories->find()->all()->toArray();
        $this->set(compact('categories'));
    }
}
