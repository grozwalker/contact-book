<?php

namespace test\HTTP;

use App\Http\RouterCollection;
use App\Http\Router;
use App\Http\RequestNotMatchException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Uri;

class RouterTest extends TestCase
{
    /** @test */
    function test_correct_method(): void
    {
        $routers = new RouterCollection();

        $routers->get($nameGet = 'about', '/about', $handlerGet = 'get_handler');
        $routers->post($namePost = 'about_create', '/about', $handlerPost = 'post_handler');

        $router = new Router($routers);

        $result = $router->match($this->buildRequest('GET', '/about'));
        self::assertEquals($nameGet, $result->getName());
        self::assertEquals($handlerGet, $result->getHandler());


        $result = $router->match($this->buildRequest('POST', '/about'));
        self::assertEquals($namePost, $result->getName());
        self::assertEquals($handlerPost, $result->getHandler());
    }

    /** @test */
    function exception_when_incorrect_method(): void
    {
        $routers = new RouterCollection();

        $routers->get($nameGet = 'about', '/about', $handlerGet = 'get_handler');

        $router = new Router($routers);

        self::expectException(RequestNotMatchException::class);
        $router->match($this->buildRequest('POST', '/about'));
    }

    /** @test */
    function router_can_has_attributes(): void
    {
        $routers = new RouterCollection();

        $routers->get($name = 'contacts', '/contacts/2', 'handler', ['id' => '\d+']);

        $router = new Router($routers);

        $result = $router->match($this->buildRequest('GET', '/about'));
        self::assertEquals($name, $result->getName());
        self::assertEquals(['id' => '2'], $result->getAttributes());
    }

    /** @test */
    function exception_when_incorrect_attributes(): void
    {
        $routers = new RouterCollection();

        $routers->get($name = 'contacts', '/contacts/{id}', 'handler', ['id' => '\d+']);

        $router = new Router($routers);

        self::expectException(RequestNotMatchException::class);
        $router->match($this->buildRequest('GET', '/contact/slug'));
    }

    /** @test */
    function generate_correct_url(): void
    {
        $routers = new RouterCollection();

        $routers->get('contacts', '/contacts', 'handler');
        $routers->get('contacts_view', '/contacts/{id}', 'handler', ['id' => '\d+']);

        $router = new Router($routers);

        self::assertEquals('contacts', $router->generate('contacts'));
        self::assertEquals('contacts/3', $router->generate('contacts_view', ['id' => '5']));
    }

    /** @test */
    function exception_when_incorrect_type_attributes(): void
    {
        $routers = new RouterCollection();

        $routers->get($name = 'contacts', '/contacts/{id}', 'handler', ['id' => '\d+']);

        $router = new Router($routers);

        self::expectException(\InvalidArgumentException::class);
        $router->generate('contacts', ['id' => 'slug']);
    }

    /**
     * @param string $method
     * @param string $uri
     * @return RequestInterface
     */
    private function buildRequest(string $method, string $uri): RequestInterface
    {
        return (new ServerRequest())
            ->withMethod($method)
            ->withUri(new Uri($uri));
    }
}