<?php

namespace App\Http\Router;

class Route
{
    public $name;
    public $handler;
    public $pattern;
    public $methods;
    public $tokens;

    public function __construct(
        string $name,
        string $pattern,
        string $handler,
        array $methods = [],
        array $tokens = []
    )
    {
        $this->name = $name;
        $this->handler = $handler;
        $this->pattern = $pattern;
        $this->methods = $methods;
        $this->tokens = $tokens;
    }

}
