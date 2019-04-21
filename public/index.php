<?php

use \Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use \Zend\Diactoros\ServerRequestFactory;
use \Zend\Diactoros\Response\HtmlResponse;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$request = ServerRequestFactory::fromGlobals();

$name = $request->getQueryParams()['name'] ?? 'Guest';

$response = (new HtmlResponse("Hello, {$name}!"))
    ->withHeader('Author', 'Andrey');

$emitter = new SapiEmitter();
$emitter->emit($response);