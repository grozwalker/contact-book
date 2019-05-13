<?php

namespace App\Http\Router\Exceptions;

use Psr\Http\Message\ServerRequestInterface;

class RequestNotMatchedException extends \Exception
{
    private $request;

    public function __construct(ServerRequestInterface $request)
    {
        parent::__construct('Matches not found.');
        $this->request = $request;
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }
}
