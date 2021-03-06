<?php

namespace App\Http\Router;

/**
 * Возвращаемый найденный роут
 * Class Result
 * @package App\Http\Router
 */
class Result
{
    protected $name;
    protected $handler;
    protected $attributes = [];

    public function __construct($name, $handler, array $attributes)
    {
        $this->name = $name;
        $this->handler = $handler;
        $this->attributes = $attributes;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
