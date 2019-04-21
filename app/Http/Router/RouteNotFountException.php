<?php


namespace App\Http;


class RouteNotFountException extends \LogicException
{
    private $name;
    private $params;

    /**
     * RouteNotFountException constructor.
     * @param $name
     * @param array $params
     */
    public function __construct($name, array $params = [])
    {
        parent::__construct("Route ${name} not find");
        $this->name = $name;
        $this->params = $params;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}