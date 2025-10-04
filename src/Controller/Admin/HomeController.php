<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AuthController;
use App\Service\UploadImageService;
use Cake\ORM\Table;

class HomeController extends AuthController
{
    private UploadImageService $UploadImage;
    protected Table $Categories;
    protected Table $Products;

    public function index(): void
    {

    }

}
