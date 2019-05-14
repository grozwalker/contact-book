<?php

namespace App\Http\Pipeline;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Next
 * @package App\Http\Pipeline
 */
class Next
{
    protected $queue;
    protected $default;

    public function __construct(\SplQueue $queue, callable $default)
    {
        $this->queue = $queue;
        $this->default = $default;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->queue->isEmpty()) {
            return ($this->default)($request);
        }

        $current = $this->queue->dequeue();

        /**
         * Формируем цепочку вызовов вложенных друг в друга
         */
        return $current($request, function ($request) {
            return $this->handle($request);
        });
    }

}