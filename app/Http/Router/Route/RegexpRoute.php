<?php

namespace App\Http\Router\Route;

use App\Http\Router\Result;
use Psr\Http\Message\ServerRequestInterface;

//TODO заменить на Symfony || Zend router

/**
 * Роутер на регулярных выражениях. Инкапусляции логика поиска
 * Class RegexpRoute
 * @package App\Http\Router\Route
 */
class RegexpRoute implements Route
{
    public $name;
    public $handler;
    public $pattern;
    public $methods;
    public $tokens;

    public function __construct(
        $name,
        $pattern,
        $handler,
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

    /**
     * Находим соответствие по регулярным выражениям и параметр
     * @param ServerRequestInterface $request
     * @return Result|null
     */
    public function match(ServerRequestInterface $request): ?Result
    {
        /**
         * Если даже метода нет, то дальше не идем
         */
        if($this->methods && !in_array($request->getMethod(), $this->methods, true)) {
            return null;
        }

        $pattern = preg_replace_callback('~\{([^\}]+)\}~', function ($matches) {
            $argument = $matches[1];

            $replace = $route->tokens[$argument] ?? '[^}]+';

            return '(?P<' . $argument . '>' . $replace . ')';
        }, $this->pattern);

        /**
         * Если нашли нужные роут возвращаем результат.
         * Новый объект для лучше реализации ООП
         */
        if (preg_match('~^' . $pattern . '$~i', $request->getUri()->getPath(), $matches)) {
            return new Result(
                $this->name,
                $this->handler,
                array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY)
            );
        }

        return null;
    }

    /**
     * Генерируем урл по имени
     * @param $name
     * @param array $params
     * @return string|null
     */
    public function generate($name, $params = []): ?string
    {
        if ($name !== $this->name) {
            return null;
        }

        $url = preg_replace_callback('~\{([^\}]+)\}~', function ($matches) use ($params, $name) {
            $argument = $matches[1];

            if (!array_key_exists($argument, $params)) {
                throw new \InvalidArgumentException("RegexpRoute ${$name} not found");
            }

            return $params[$argument];

        }, $this->pattern);

        if ($url !== null) {
            return $url;
        }

        return null;

    }

}
