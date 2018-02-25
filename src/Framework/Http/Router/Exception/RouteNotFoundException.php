<?php
namespace Framework\Http\Router\Exception;

/**
 * [RouteNotFoundException description]
 */

class RouteNotFoundException extends \LogicException
{
    private $name;
    private $params;

    public function __construct($name, array $params)
    {
        parent::__construct("Route \"{$name}\" not found");
        $this->name = $name;
        $this->params = $params;
    }

    public function getName(): string
    {
        return $this->nane;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}