<?php

namespace App\Http\Router;

use App\Http\Router\Exceptions\RequestNotMatchedException;
use App\Http\Router\Exceptions\RouteNotFountException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * В коллекции (массиве) роутов находим соответствие и возвращаем
 * Class Router
 * @package App\Http\Router
 */
class Router implements RoutesInterface
{
    private $routes;

    public function __construct(RouterCollection $routes)
    {
        $this->routes = $routes;
    }

    public function match(ServerRequestInterface $request): Result
    {
        foreach ($this->routes->getRoutes() as $route) {
            $result = $route->match($request);

            if ($result) {
                return $result;
            }
        }

        throw new RequestNotMatchedException($request);
    }

    public function generate($name, $params = []): string
    {

        foreach ($this->routes->getRoutes() as $route) {
            $url = $route->generate($name, array_filter($params));

            if ($url) {
                return $url;
            }
        }

        throw new RouteNotFountException($name, $params);
    }
}
