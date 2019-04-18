<?php

use App\Http\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    /** @test */
    function response_has_correct_body(): void
    {
        $response = new Response($body = 'testBody');

        self::assertEquals($body, $response->getBody());
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('OK', $response->getReasonPhrase());
    }

    /** @test */
    function response_has_correct_404(): void
    {
        $response = new Response($body = 'testBody', $status = 404);

        self::assertEquals($body, $response->getBody());
        self::assertEquals($status, $response->getStatusCode());
        self::assertEquals('Not Found', $response->getReasonPhrase());
    }

    /** @test */
    function response_has_correct_headers(): void
    {
        $response = (new Response(''))
            ->withHeader($name1 = 'Header 1', $value1 = 'Value 1')
            ->withHeader($name2 = 'Header 2', $value2 = 'Value 2');

        self::assertEquals([
            $name1 => $value1,
            $name2 => $value2
        ], $response->getHeaders());
    }
}