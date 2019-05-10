<?php

namespace App\Http\Middleware;

use App\Container\Container;
use App\Http\Pipeline\Resolver;
use App\Http\Router\Exceptions\RequestNotMatchedException;
use App\Http\Router\Result;
use App\Http\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DispatchMiddleware
{
    private $router;
    private $resolver;

    public function __construct(Router $router, Resolver $resolver)
    {
        $this->router = $router;
        $this->resolver = $resolver;
    }

    public function __invoke(ServerRequestInterface $request, callable $handler): ResponseInterface
    {
        if (!$result = $request->getAttribute(Result::class)) {
            return $handler($request);
        }

        $handler = $result->getHandler();
        $middleware = $this->resolver->resolve($handler);

        return $middleware($request, $handler);
    }
}