<?php

namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PsrHandlerWrapper implements RequestHandlerInterface
{
    protected $callback;

    public function __construct(callable $callback)
    {

        $this->callback = $callback;
    }

    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return ($this->callback)($request);
    }
}