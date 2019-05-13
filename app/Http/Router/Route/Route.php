<?php

namespace App\Http\Router\Route;

use App\Http\Router\Result;
use Psr\Http\Message\ServerRequestInterface;

interface Route
{
    public function match(ServerRequestInterface $request): ?Result;

    public function generate($name, $params = []): ?string;
}