<?php

use App\Application;
use App\Http\Middleware\DispatchMiddleware;
use App\Http\Middleware\ErrorHandlerMiddleware;
use App\Http\Middleware\ProfilerMiddleware;
use App\Http\Middleware\RouteMiddleware;
use App\Http\Router\Router;
use \Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use \Zend\Diactoros\ServerRequestFactory;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$container = require 'config/container.php';


### Running

$request = ServerRequestFactory::fromGlobals();

/** @var Application $app */
$app = $container->get(Application::class);

/** @var Router $app */
$router = $container->get(Router::class);

require 'config/pipelines.php';

$response = $app->handle($request);


### Response

$emitter = new SapiEmitter();
$emitter->emit($response);

//TODO
/*
 * Implement MiddlewareInterface
 */