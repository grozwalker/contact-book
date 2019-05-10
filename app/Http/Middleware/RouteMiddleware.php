<?php

namespace App\Http\Middleware;

use App\Container\Container;
use App\Http\Pipeline\Resolver;
use App\Http\Router\Exceptions\RequestNotMatchedException;
use App\Http\Router\Result;
use App\Http\Router\Router;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouteMiddleware
{
    private $router;
    private $resolver;

    public function __construct(Router $router, Resolver $resolver)
    {
        $this->router = $router;
        $this->resolver = $resolver;
    }

    public function __invoke(ServerRequestInterface $request, callable $handler)
    {
        try {
            $result = $this->router->match($request);
            foreach ($attributes = $result->getAttributes() as $attribute => $value) {
                $request = $request->withAttribute($attribute, $value);
            }

            return $handler($request->withAttribute(Result::class, $result), $handler);
        } catch (RequestNotMatchedException $exception) {
            return $handler($request, $handler);
        }
    }
}