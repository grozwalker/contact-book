<?php
namespace App\Http;

class Request
{
    private $queryParams = [];
    private $parsedBody;

    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * @param array $queryParams
     * @return Request
     */
    public function withQueryParams(array $queryParams): self
    {
        $new = clone $this;
        $new->queryParams = $queryParams;

        return $new;
    }

    public function getParsedBody()
    {
        return $this->parsedBody ?: null;
    }

    /**
     * @param null $parsedBody
     * @return Request
     */
    public function withParsedBody($parsedBody): self
    {
        $new = clone $this;
        $new->parsedBody = $parsedBody;

        return $new;
    }

}