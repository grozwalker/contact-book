<?php

use App\Container\Container;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\NotFoundHandler;
use App\Http\Middleware\ProfilerMiddleware;
use App\Http\Pipeline\Pipeline;
use Psr\Http\Message\ServerRequestInterface;

$routes->get('home', '/', [HomeController::class, 'index']);
/*$routes->get('home', '/', function (ServerRequestInterface $request, Container $container) {

    $pipeline = new Pipeline();
    $pipeline->pipe(function () use ($request, $container) {
        return $container->get(HomeController::class)->index($request);
    });

    return $pipeline($request, new NotFoundHandler());
});*/


$routes->get('contact.view', '/contact/{id}', [ContactController::class, 'show'], ['id' => '\d+']);
