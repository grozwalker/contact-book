<?php

namespace App\Http\Pipeline;

use App\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class Resolver
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function resolve($handler): callable
    {
        if (is_string($handler)) {
            return function (ServerRequestInterface $request, callable $next) use ($handler) {
                $obj = $this->container->get($handler);

                return $obj($request, $next);
            };
        }

        if (is_array($handler)) {
            return function (ServerRequestInterface $request, callable $next) use ($handler) {
                $class = $handler[0];
                $method = $handler[1];

                $obj = $this->container->get($class);

                return $obj->$method($request, $next);
            };
        }

        if (is_object($handler)) {

            return function (ServerRequestInterface $request, callable $next) use ($handler) {

                return $handler($request, $next);
            };
        }

        return $handler;

    }
}
