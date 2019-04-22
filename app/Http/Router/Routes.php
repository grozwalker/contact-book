<?php

namespace App\Http\Router;

use App\Http\Router\Exceptions\RequestNotMatchedException;
use App\Http\Router\Exceptions\RouteNotFountException;
use Psr\Http\Message\ServerRequestInterface;

class Routes implements RoutesInterface
{
    private $routes;

    public function __construct(RouterCollection $routes)
    {
        $this->routes = $routes;
    }

    public function match(ServerRequestInterface $request): Result
    {
        foreach ($this->routes->getRoutes() as $route) {
            if($route->methods && !in_array($request->getMethod(), $route->methods, true)) {
                continue;
            }

            $pattern = preg_replace_callback('~\{([^\}]+)\}~', function ($matches) use ($route) {
                $argument = $matches[1];

                $replace = $route->tokens[$argument] ?? '[^}]+';

                return '(?P<' . $argument . '>' . $replace . ')';
            }, $route->pattern);
/*
            echo $pattern . '\n';
            echo '----';*/
            //die();

            if (preg_match('~^' . $pattern . '$~i', $request->getUri()->getPath(), $matches)) {
                //print_r($route);
                return new Result(
                    $route->name,
                    $route->handler,
                    array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY)
                );
            }
        }

        throw new RequestNotMatchedException($request);
    }

    public function generate($name, $params = []): string
    {
        $arguments = array_filter($params);

        foreach ($this->routes->getRoutes() as $route) {
            if ($name !== $route->name) {
                continue;
            }

            $url = preg_replace_callback('~\{([^\}]+)\}~', function ($matches) use ($arguments, $name) {
                $argument = $matches[1];

                if (!array_key_exists($argument, $arguments)) {
                    throw new \InvalidArgumentException("Route ${$name} not found");
                }

                return $arguments[$argument];

            }, $route->pattern);

            if ($url !== null) {
                return $url;
            }

        }

        echo 'nooooo';

        throw new RouteNotFountException($name, $params);
    }
}
