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
};
