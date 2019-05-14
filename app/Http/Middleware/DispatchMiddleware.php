<?php

namespace App\Http\Middleware;

use App\Http\Pipeline\Resolver;
use App\Http\Router\Result;
use App\Http\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Получаем метод обработки и вызываем его
 * Class DispatchMiddleware
 * @package App\Http\Middleware
 */
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
        /**
         * Если результата нет, то сразу вызываем ф-цию по-умолчанию (NotFoundHandler)
         */
        if (!$result = $request->getAttribute(Result::class)) {
            return $handler($request);
        }

        $handler = $result->getHandler();
        $middleware = $this->resolver->resolve($handler);

        return $middleware($request, $handler);
    }
}