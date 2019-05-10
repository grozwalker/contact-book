<?php

namespace App\Container;

use ReflectionClass;
use Zend\Diactoros\Response\JsonResponse;

class Container
{
    private $storage = [];
    private $results = [];

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        if (false === array_key_exists($key, $this->storage)) {
            if (class_exists($key)) {
                try {
                    $reflection = new ReflectionClass($key);
                } catch (\ReflectionException $e) {
                    return new JsonResponse([
                        'message' => $e->getMessage(),
                        'trace' => $e->getTrace(),
                    ], 500);
                }
                $arguments = [];

                if (($constructor = $reflection->getConstructor()) !== null) {
                    foreach ($constructor->getParameters() as $param) {
                        $className = $param->getClass()->getName();

                        if ($className === self::class) {
                            $arguments[] = $this;
                        } else {
                            $arguments[] = $this->get($className);
                        }
                    }
                }

                return $this->storage[$key] = new $key(...$arguments);
            }

            throw new KeyNotFoundException('Undefined param ' . $key);
        }

        if (array_key_exists($key, $this->results)) {
            return $this->results[$key];
        }

        $definition = $this->storage[$key];

        if ($definition instanceof \Closure) {
            $this->results[$key] = $definition($this);
        } else {
            $this->results[$key] = $definition;
        }

        return $this->results[$key];
    }

    public function has($key): bool
    {
        return array_key_exists($key, $this->storage) || class_exists($key);
    }

    public function set($key, $value): void
    {
        if (array_key_exists($key, $this->results)) {
            unset($this->results[$key]);
        }

        $this->storage[$key] = $value;
    }
}