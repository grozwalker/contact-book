<?php

namespace App\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Оборачиваем цепочку вызовов в try/catch, чтобы обрабатывать возможные ошибки
 * Class ErrorHandlerMiddleware
 * @package App\Http\Middleware
 */
class ErrorHandlerMiddleware
{
    protected $debug;

    public function __construct(bool $debug = false)
    {
        $this->debug = $debug;
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        try {
            return $next($request);
        } catch (Throwable $error) {
            if ($this->debug) {
                return new JsonResponse([
                    'error' => 'Server error',
                    'code' => $error->getCode(),
                    'message' => $error->getMessage(),
                    'trace' => $error->getTrace(),
                ],
                    500);
            } else {
                return new JsonResponse('Server Error', 500);
            }
        }
    }
}