<?php

namespace App\Container;

use ReflectionException;

interface ContainerInterface
{
    /**
     * @param $key
     * @return mixed
     * @throws ReflectionException
     * @throws KeyNotFoundException
     */
    public function get($key);

    public function has($key): bool;
}