<?php

namespace App\Http\Middleware;

use App\Http\Pipeline\Resolver;
use App\Http\Router\Exceptions\RequestNotMatchedException;
use App\Http\Router\Result;
use App\Http\Router\Router;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Находим соответствия урла в реквесте с нашими заданными роутами
 * Все распарсенные атрибуты добавляем к реквесту
 *
 * П.с.
 * Разделил обработку роутов и сам вызов ф-ции из роута (DispatchMiddleware), чтобы
 * можно было между ними вставлять другие middleware (типа BodyParse)
 * Class RouteMiddleware
 * @package App\Http\Middleware
 */
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
            /**
             * Находим соответствие урла и роута
             */
            $result = $this->router->match($request);
            foreach ($attributes = $result->getAttributes() as $attribute => $value) {
                $request = $request->withAttribute($attribute, $value);
            }

            /**
             * К реквесту добавляем полученный результат, чтобы в DispatcherMiddleware получить
             */
            return $handler($request->withAttribute(Result::class, $result), $handler);
        } catch (RequestNotMatchedException $exception) {
            return $handler($request, $handler);
        }
    }
}