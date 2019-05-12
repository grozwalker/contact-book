<?php

use App\Application;
use App\Container\Container;
use App\Http\Middleware\ErrorHandlerMiddleware;
use App\Http\Middleware\NotFoundHandler;
use App\Http\Pipeline\Resolver;
use App\Http\Router\Router;
use App\Http\Router\RouterCollection;
use ContainerInteropDoctrine\EntityManagerFactory;

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
            "mysql:host={$container->get('db')['servername']};dbname=docker;charset=utf8",
            $container->get('db')['username'],
            $container->get('db')['password'],
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
        return new ErrorHandlerMiddleware($container->get('debug'));
    },
    Resolver::class => function (Container $container) {
        return new Resolver($container);
    },
    'doctrine.entity_manager.orm_default' => function (Container $container) {
        return new EntityManagerFactory();
    },
];
