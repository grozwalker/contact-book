<?php

namespace App\Http;

use \Psr\Http\Message\ResponseInterface;

class ResponseSender
{
    public function send(ResponseInterface $response)
    {
        header("HTTP/1.1 {$response->getStatusCode()} {$response->getReasonPhrase()}");

        foreach ($response->getHeaders() as $headerName => $headerValues) {
            header($headerName . ': ' . implode(', ', $headerValues));
        }

        echo $response->getBody()->getContents();
    }
}