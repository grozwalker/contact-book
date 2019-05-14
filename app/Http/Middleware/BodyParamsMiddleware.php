<?php

namespace App\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Парсим request и помещаем распарсенный массив данных в parsedBody
 * Class BodyParamsMiddleware
 * @package App\Http\Middleware
 */
class BodyParamsMiddleware
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $contentType = $request->getHeaderLine('Content-Type');

        $parts = explode(';', $contentType);
        $mime = trim(array_shift($parts));

        if (preg_match('#[/+]json$#', $mime)) {
            $rawBody = $request->getBody()->getContents();
            $parsedBody = json_decode($rawBody, true);

            if (!empty($rawBody) && json_last_error()) {
                throw new \InvalidArgumentException('Error when parsing JSON request body: ' . json_last_error_msg());
            }

            $request = $request->withParsedBody($parsedBody);
        }

        return $next($request);
    }
}
