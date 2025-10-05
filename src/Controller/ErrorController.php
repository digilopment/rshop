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
    }

    public function beforeFilter(EventInterface $event): void
    {
    }

    public function beforeRender(EventInterface $event): void
    {
        parent::beforeRender($event);
        $this->viewBuilder()->setTemplatePath('Error');
    }

    public function afterFilter(EventInterface $event): void
    {
    }
}
