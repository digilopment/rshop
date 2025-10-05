<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AuthController;
use Cake\ORM\Table;

class HomeController extends AuthController
{
    protected Table $Categories;
    protected Table $Products;

    public function index(): void
    {

    }

}
