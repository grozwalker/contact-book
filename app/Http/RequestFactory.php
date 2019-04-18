<?php


namespace App\Http;


class RequestFactory
{
    public static function createFromGlobals(array $query = null, $data = null): Request
    {
        return (new Request())
            ->withQueryParams($query ?: $_GET)
            ->withParsedBody($data ?: $_POST);
    }

}