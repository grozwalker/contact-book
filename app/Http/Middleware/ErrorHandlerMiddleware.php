<?php

namespace App\Http\Middleware;

use App\Container\Container;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class ErrorHandlerMiddleware
{
    protected $debug;

    public function __construct(Container $container)
    {

        $this->debug = $container->get('config')['debug'];
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        try {
            return $next($request);
        } catch ( \Throwable $error ) {
            if ($this->debug) {
                return new JsonResponse([
                    'error' => 'Server error',
                    'code'  => $error->getCode(),
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