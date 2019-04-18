<?php

use \App\Http\RequestFactory;
use App\Http\Response;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$request = RequestFactory::createFromGlobals();

$name = $request->getQueryParams()['name'] ?? 'Guest';

$response = (new Response("Hello, {$name}"))
    ->withHeader('Author', 'Andrey');

header("HTTP/1.1 {$response->getStatusCode()} {$response->getReasonPhrase()}");
foreach ($response->getHeaders() as $headerName => $headerValue) {
    header("${headerName}: {$headerValue}");
}

echo $response->getBody();