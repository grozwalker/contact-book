<?php

namespace App\Http;

class RouterCollection
{
    private $routes = [];

    public function get($name, $pattern, $handler, array $tokens = [])
    {
        $this->routes = new Route($name, $pattern, $handler, ['GET'], $tokens);
    }

    public function post($name, $pattern, $handler, array $tokens = [])
    {
        $this->routes = new Route($name, $pattern, $handler, ['POST'], $tokens);
    }

    public function put($name, $pattern, $handler, array $tokens = [])
    {
        $this->routes = new Route($name, $pattern, $handler, ['PUT'], $tokens);
    }

    public function delete($name, $pattern, $handler, array $tokens = [])
    {
        $this->routes = new Route($name, $pattern, $handler, ['DELETE'], $tokens);
    }

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

}