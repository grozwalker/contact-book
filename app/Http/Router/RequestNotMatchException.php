<?php


namespace App\Http;


use Psr\Http\Message\ServerRequestInterface;

class RequestNotMatchException extends \LogicException
{
    private $request;

    /**
     * RequestNotMatchException constructor.
     * @param ServerRequestInterface $request
     */
    public function __construct(ServerRequestInterface $request)
    {
        parent::__construct('Method Not Found');
        $this->request = $request;
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }
}