<?php

namespace App\Container;

use Closure;
use ReflectionClass;

/**
 * Хранит/Создает конфиги и сервисы
 * Class Container
 * @package App\Container
 */
class Container implements ContainerInterface
{
    /**
     * Все, что мы сконфигурировали и положили в контейнер
     * при загрузке приложения
     * @var array
     */
    private $settings = [];

    /**
     * Когда создаем объект, помещаем сюда и при следущем вызове забираем отсюда
     * @var array
     */
    private $results = [];

    public function __construct(array $settings = [])
    {
        $this->settings = $settings;
    }

    /**
     * @param $key
     * @return mixed
     * @throws \ReflectionException
     */
    public function get($key)
    {
        /**
         * Если что-то ранее небыло скофнигурировано,
         * то пытаемся создать объект через рефлексию и вернуть его
         */
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

        /**
         * Если ф-ция замыкания, то передаем туда контейнер
         */
        if ($definition instanceof Closure) {
            $this->results[$key] = $definition($this);
        } else {
            $this->results[$key] = $definition;
        }

        return $this->results[$key];
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key): bool
    {
        return array_key_exists($key, $this->settings) || class_exists($key);
    }
}