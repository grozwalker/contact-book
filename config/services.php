<?php

use App\Application;
use App\Container\Container;
use App\Http\Middleware\ErrorHandlerMiddleware;
use App\Http\Middleware\NotFoundHandler;
use App\Http\Pipeline\Resolver;
use App\Http\Router\Router;
use App\Http\Router\RouterCollection;

return [
    Application::class => function (Container $container) {
        return new Application(
            $container->get(Resolver::class),
            $container->get(Router::class),
            $container->get(NotFoundHandler::class)
        );
    },
    PDO::class => function ($container) {
        return new PDO(
            "mysql:host={$container->get('config')['db']['servername']};dbname=docker;charset=utf8",
            $container->get('config')['db']['username'],
            $container->get('config')['db']['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]
        );
    },
    'routes' => function (Container $container) {
        $routes = new RouterCollection();

        require 'routes/routes.php';

        return $routes;
    },
    Router::class => function (Container $container) {
        return new Router($container->get('routes'));
    },
    ErrorHandlerMiddleware::class => function (Container $container) {
        return new ErrorHandlerMiddleware($container->get('config')['debug']);
    },
    Resolver::class => function (Container $container) {
        return new Resolver($container);
    },
];
