<?php

use App\Application;
use App\Http\Router\Router;
use App\Models\Database;
use \Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use \Zend\Diactoros\ServerRequestFactory;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

//TODO Надо было бы убрать тоже это в контейнер.
/*
 * Хотел вместо illuminate/database использовать doctrine
 * Но он, конечно, гораздо сложнее и плюс бы еще пришлось переписывать миграции
 * Поэтому оставил эту затею
 */
$db = new Database();

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
 * Create request validation
 */