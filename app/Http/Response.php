<?php


namespace App\Http;


class Response
{
    private $body;
    private $statusCode;
    private $reasonPhrase = '';
    private $headers = [];

    private static $phrases = [
        200 => 'OK',
        301 => 'Move Permanently',
        400 => 'Bad Request',
        404 => 'Not Found',
        422 => 'Validation Required',
        500 => 'Internal Server Error'
    ];

    public function __construct($body, $statusCode = 200)
    {
        $this->body = $body;
        $this->statusCode = $statusCode;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     * @return Response
     */
    public function withBody($body): self
    {
        $new = clone $this;
        $new->body = $body;

        return $new;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function hasHeader($header): bool
    {
        return array_key_exists($header, $this->headers);
    }

    /**
     * @param $header
     * @return string
     */
    public function getHeader(string $header): string
    {
        if ($this->hasHeader($header)) {
            return null;
        }

        return $this->headers[$header];
    }

    /**
     * @param $header
     * @param $value
     * @return Response
     */
    public function withHeader($header, $value): self
    {
        $new = clone $this;

        if ($this->hasHeader($header)) {
            unset($new->headers[$header]);
        }

        $new->headers[$header] = $value;

        return $new;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getReasonPhrase(): string
    {
        if (!$this->reasonPhrase && isset(self::$phrases[$this->statusCode])) {
            return self::$phrases[$this->statusCode];
        }

        return $this->reasonPhrase;
    }

    /**
     * @param int $statusCode
     * @param string $reasonPhrase
     * @return Response
     */
    public function withStatus(int $statusCode, string $reasonPhrase = ''): self
    {
        $new = clone $this;
        $new->statusCode = $statusCode;
        $new->reasonPhrase = $reasonPhrase;

        return $new;
    }
}