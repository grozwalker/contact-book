<?php

use App\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    /** @test */
    function request_has_empty_params(): void
    {
        $request = new Request([]);

        self::assertEquals([], $request->getQueryParams());
        self::assertNull($request->getParsedBody());
    }

    /** @test */

    function request_has_right_header(): void
    {
        $request = (new Request())
            ->withQueryParams($data = [
                'me' => 'Andrushka',
                'she' => 'Lenushka',
            ]);

        self::assertEquals($data, $request->getQueryParams());
        self::assertNull($request->getParsedBody());
    }

    /** @test */
    function request_has_right_body(): void
    {
        $request = (new Request())
            ->withParsedBody($data = [
                'develop' => 'Andrushka',
            ]);

        self::assertEquals([], $request->getQueryParams());
        self::assertEquals($data, $request->getParsedBody());

    }
}