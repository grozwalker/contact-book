<?php

namespace test\HTTP;

use App\Http\Pipeline\Pipeline;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequest;

class PipelineTest extends TestCase
{
    /** @test */
    public function can_use_pipeline()
    {
        $pipeline = new Pipeline();

        $pipeline->pipe(new Middleware1());
        $pipeline->pipe(new Middleware2());

        $response = $pipeline(new ServerRequest(), new Last());

        $this->assertJsonStringEqualsJsonString(
            json_encode(['Attr-1' => 1, 'Attr-2' => 2,]),
            $response->getBody()->getContents()
        );
    }
}

class Middleware1
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        return $next($request->withAttribute('Attr-1', 1));
    }
}

class Middleware2
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        return $next($request->withAttribute('Attr-2', 2));
    }
}

class Last
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse($request->getAttributes());
    }
}