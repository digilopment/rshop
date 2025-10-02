<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;

class AppController extends Controller
{
    protected $Categories;

    /**
     * Initialization hook method.
     */
    public function initialize(): void
    {
        parent::initialize();

        // RequestHandlerComponent už v CakePHP 5 neexistuje
        // $this->loadComponent('RequestHandler');

        $this->loadComponent('Flash');

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * $this->loadComponent('FormProtection');
         */
        
        // Načíta model Categories
        $this->Categories = $this->fetchTable('Categories');
    }
    
    public function beforeRender(EventInterface $event): void
    {
        parent::beforeRender($event);

        // Načíta všetky kategórie
        $categories = $this->Categories->find()->all()->toArray();
        $this->set(compact('categories'));
    }
}
