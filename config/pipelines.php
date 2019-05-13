<?php

use App\Http\Middleware\BodyParamsMiddleware;
use App\Http\Middleware\DispatchMiddleware;
use App\Http\Middleware\ErrorHandlerMiddleware;
use App\Http\Middleware\ProfilerMiddleware;
use App\Http\Middleware\RouteMiddleware;

$app->pipe(ErrorHandlerMiddleware::class);
$app->pipe(ProfilerMiddleware::class);
$app->pipe(RouteMiddleware::class);
$app->pipe(BodyParamsMiddleware::class);
$app->pipe(DispatchMiddleware::class);
