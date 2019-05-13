<?php

namespace App\Container;

use Closure;
use ReflectionClass;

class Container implements ContainerInterface
{
    private $settings = [];
    private $results = [];

    public function __construct(array $settings = [])
    {
        $this->settings = $settings;
    }

    public function get($key)
    {
        if (false === array_key_exists($key, $this->settings)) {
            if (class_exists($key)) {
                $reflection = new ReflectionClass($key);
                $arguments = [];

                if (($constructor = $reflection->getConstructor()) !== null) {
                    foreach ($constructor->getParameters() as $param) {
                        $className = $param->getClass()->getName();
                        $arguments[] = $this->get($className);
                    }
                }

                return $this->settings[$key] = new $key(...$arguments);
            }

            throw new KeyNotFoundException('Undefined param ' . $key);
        }

        if (array_key_exists($key, $this->results)) {
            return $this->results[$key];
        }

        $definition = $this->settings[$key];

        if ($definition instanceof Closure) {
            $this->results[$key] = $definition($this);
        } else {
            $this->results[$key] = $definition;
        }

        return $this->results[$key];
    }

    public function has($key): bool
    {
        return array_key_exists($key, $this->settings) || class_exists($key);
    }
}