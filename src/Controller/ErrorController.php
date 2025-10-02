<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Error Handling Controller
 *
 * Controller used by ExceptionRenderer to render error responses.
 */
class ErrorController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        // RequestHandlerComponent už v CakePHP 5 neexistuje
        // $this->loadComponent('RequestHandler'); // odstrániť
    }

    public function beforeFilter(EventInterface $event): void
    {
        // môžeš tu ponechať prázdne
    }

    public function beforeRender(EventInterface $event): void
    {
        parent::beforeRender($event);

        // Nastavenie template do Error folder
        $this->viewBuilder()->setTemplatePath('Error');
    }

    public function afterFilter(EventInterface $event): void
    {
        // môžeš tu ponechať prázdne
    }
}
