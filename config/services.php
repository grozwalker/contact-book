<?php

use App\Application;
use App\Container\Container;
use App\Http\Middleware\NotFoundHandler;
use App\Http\Pipeline\Resolver;
use App\Http\Router\Router;
use App\Http\Router\RouterCollection;

$container->set(Application::class, function (Container $container) {
    return new Application(
        $container->get(Resolver::class),
        $container->get(Router::class),
        $container->get(NotFoundHandler::class)
    );
});

$container->set(PDO::class, function ($container) {
    return new PDO(
        "mysql:host={$container->get('config')['db']['servername']};dbname=docker",
        $container->get('config')['db']['username'],
        $container->get('config')['db']['password']);
});

$container->set('routes', function (Container $container) {
    $routes = new RouterCollection();

    require 'routes/routes.php';

    return $routes;
});

$container->set(Router::class, function (Container $container) {
    return new Router($container->get('routes'));
});
