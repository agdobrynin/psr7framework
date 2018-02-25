<?php
namespace Framework\Http\Router;

use \Framework\Http\Router\Route;

class RouteCollection
{
    private $routes = [];

    public function get($name, $pattern, $handler, array $tokens =[]): void
    {
        $this->routes[] = new Route($name, $pattern, $handler, ['GET'], $tokens);
    }

    public function post($name, $pattern, $handler, array $tokens =[]): void
    {
        $this->routes[] = new Route($name, $pattern, $handler, ['POST'], $tokens);
    }

    public function any($name, $pattern, $handler, array $tokens =[]): void
    {
        $this->routes[] = new Route($name, $pattern, $handler, [], $tokens);
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}
