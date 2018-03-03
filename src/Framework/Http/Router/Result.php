<?php
namespace Framework\Http\Router;

class Result
{
    private $name;
    private $handler;
    private $attributes;

    public function __construct($name, $handeler, array $attributes)
    {
        $this->name = $name;
        $this->handler = $handeler;
        $this->attributes = $attributes;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getHandler()
    {
        return $this->handler;
    }
}
