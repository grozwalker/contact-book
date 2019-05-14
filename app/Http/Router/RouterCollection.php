<?php

namespace App\Http\Router;

use App\Http\Router\Route\RegexpRoute;

/**
 * Заполняем коллецию роутов
 * Class RouterCollection
 * @package App\Http\Router
 */
class RouterCollection
{
    private $routes = [];

    public function get($name, $pattern, $handler, array $tokens = [])
    {
        $this->routes[] = new RegexpRoute($name, $pattern, $handler, ['GET'], $tokens);
    }

    public function post($name, $pattern, $handler, array $tokens = [])
    {
        $this->routes[] = new RegexpRoute($name, $pattern, $handler, ['POST'], $tokens);
    }

    public function put($name, $pattern, $handler, array $tokens = [])
    {
        $this->routes[] = new RegexpRoute($name, $pattern, $handler, ['PUT'], $tokens);
    }

    public function delete($name, $pattern, $handler, array $tokens = [])
    {
        $this->routes[] = new RegexpRoute($name, $pattern, $handler, ['DELETE'], $tokens);
    }

    /**
     * @return RegexpRoute[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

}
