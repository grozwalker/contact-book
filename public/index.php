<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Router\Exceptions\RequestNotMatchedException;
use App\Http\Router\RouterCollection;
use App\Http\Router\Router;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use \Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use \Zend\Diactoros\ServerRequestFactory;
use \Zend\Diactoros\Response\HtmlResponse;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$routes = new RouterCollection();


$routes->get('home', '/', [new HomeController(), 'index']);
$routes->get('contact.view', '/contact/{id}', [new ContactController(), 'view'], ['id' => '\d+']);

$router = new Router($routes);
$request = ServerRequestFactory::fromGlobals();
try {
    $result = $router->match($request);

    if ($result) {
        foreach ($attributes = $result->getAttributes() as $attribute => $value) {
            $request = $request->withAttribute($attribute, $value);
        }

        $action = $result->getHandler();

        $response = $action($request);
    }

} catch (RequestNotMatchedException $exception) {
    $response = new JsonResponse(['error' => 'Undefined Page'], 404);
}


$emitter = new SapiEmitter();
$emitter->emit($response);
