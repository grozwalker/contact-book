<?php

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use \Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use \Zend\Diactoros\ServerRequestFactory;
use \Zend\Diactoros\Response\HtmlResponse;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$request = ServerRequestFactory::fromGlobals();

$path = $request->getUri()->getPath();

if ($path === '/') {
    $action = function (ServerRequestInterface $request) {
        $name = $request->getQueryParams()['name'] ?? 'Guest';
        return new HtmlResponse("Hello, {$name}!");
    };

    $response = $action($request);
}

if ($path === '/about') {
    $action = function (ServerRequestInterface $request) {
        return new HtmlResponse("About!");
    };

    $response = $action($request);
}

if ($path === '/blog') {
    $action = function (ServerRequestInterface $request) {
        $blog = [
            ['id' => 1, 'title' => 'First article'],
            ['id' => 2, 'title' => 'Second article'],
        ];

        return new JsonResponse($blog);
    };

    $response = $action($request);
}


if (preg_match('#^/blog/(?P<id>\d+)$#i', $path, $matches)) {
    $id = $matches['id'];
    $request = $request->withAttribute('id', $id);

    $action = function (ServerRequestInterface $request) {
        $id = $request->getAttribute('id');
        if ($id > 5) {
            return new JsonResponse(['error' => 'Undefined Page'], 404);
        } else {
            return new JsonResponse(['id' => $id, 'title' => 'Article #' . $id]);

        }
    };
}

if (isset($action)) {
    $response = $action($request);
} else {
    $response = new JsonResponse(['error' => 'Undefined Page']);
}

$response = $response->withHeader('Author', 'Andrey');



$emitter = new SapiEmitter();
$emitter->emit($response);