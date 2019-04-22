<?php

namespace App\Http\Router;

use Psr\Http\Message\ServerRequestInterface;

interface RoutesInterface
{
    public function match(ServerRequestInterface $request): Result;

    public function generate($name, $params): string;
}
