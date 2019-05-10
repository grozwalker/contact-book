<?php

namespace App;

use App\Http\Pipeline\Pipeline;
use App\Http\Pipeline\Resolver;
use App\Http\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Application implements MiddlewareInterface, RequestHandlerInterface
{
    private $router;
    private $resolver;
    private $pipeline;
    private $default;

    public function __construct(Resolver $resolver, Router $router, callable $default)
    {
        $this->resolver = $resolver;
        $this->router = $router;
        $this->pipeline = new Pipeline();
        $this->default = $default;
    }

    public function pipe($middleware)
    {
        $this->pipeline->pipe($this->resolver->resolve($middleware));
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return ($this->pipeline)($request, $this->default);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return ($this->pipeline)($request, $this->default);
    }


}