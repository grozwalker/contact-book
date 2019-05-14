<?php

namespace App\Http\Pipeline;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Очередь из middlewar'ов обрабатывается поштучно
 * Class Pipeline
 * @package App\Http\Pipeline
 */
class Pipeline
{
    protected $queue;

    public function __construct()
    {
        $this->queue = new \SplQueue();
    }

    public function pipe($middleware)
    {
        $this->queue->enqueue($middleware);
    }

    public function __invoke(ServerRequestInterface $request, callable $default): ResponseInterface
    {
        $delegate = new Next($this->queue, $default);
        return $delegate->handle($request);
    }
}