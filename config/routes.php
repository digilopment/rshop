<?php

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);

    $routes->connect('/', ['controller' => 'Home', 'action' => 'index']);

    $routes->scope('/', function (RouteBuilder $builder): void {
        $builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
        $builder->connect('/pages/*', 'Pages::display');

        $builder->connect(
            '/eshop/{id}-{slug}',
            ['controller' => 'Products', 'action' => 'category'],
            [
                'pass' => ['id', 'slug'],
                'id' => '\d+',
                'slug' => '[a-z0-9\-]+',
                '_name' => 'category',
                '_method' => ['GET']
            ]
        );

        $builder->connect('/users/me', ['controller' => 'Users', 'action' => 'me']);
        $builder->connect('/users/me/edit', ['controller' => 'Users', 'action' => 'edit']);

        $builder->fallbacks();
    });

    $routes->prefix('Admin', function (RouteBuilder $builder) {
        $builder->connect('/products', ['controller' => 'Products', 'action' => 'index']);
        $builder->connect('/products/add', ['controller' => 'Products', 'action' => 'add']);
        $builder->connect('/products/edit/{id}', ['controller' => 'Products', 'action' => 'edit'], ['pass' => ['id'], 'id' => '\d+']);
        $builder->connect('/products/delete/{id}', ['controller' => 'Products', 'action' => 'delete'], ['pass' => ['id'], 'id' => '\d+']);
        
        $builder->connect('/categories', ['controller' => 'Categories', 'action' => 'index']);
        $builder->connect('/categories/add', ['controller' => 'Categories', 'action' => 'add']);
        $builder->connect('/categories/edit/{id}', ['controller' => 'Categories', 'action' => 'edit'], ['pass' => ['id'], 'id' => '\d+']);
        $builder->connect('/categories/delete/{id}', ['controller' => 'Categories', 'action' => 'delete'], ['pass' => ['id'], 'id' => '\d+']);

        $builder->fallbacks(DashedRoute::class);
    });
};

