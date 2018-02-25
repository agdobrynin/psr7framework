<?php
namespace Framework\Http\Router;

use Psr\Http\Message\ServerRequestInterface;
use Framework\Http\Router\Exception\RequestNotMatchedException;

class Router
{
    private $routes;

    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    public function match(ServerRequestInterface $request): Result
    {
        foreach ($this->routes->getRoutes() as $route) {
            if ($route->methods && in_array($request->getMethod(), $route->methods, true) == false) {
                continue;
            }

            $pattern = preg_replace_callback('~\{([^s\}]+)\}~', function ($matches) use ($route) {
                $arg = $matches[1];
                $repl = $route->tokens[$arg] ?? '[^}]+';
                return '(?P<'.$arg.'>'.$repl.')';
            }, $route->pattern);

            if (preg_match('~^'.$pattern.'$~i', $request->getUri()->getPath(), $matches)) {
                return new Result(
                    $route->name,
                    $route->handler,
                    array_filter($matches, '\is_string', ARRAY_FILTER_USE_KEY)
                );
            }
        }
        throw new RequestNotMatchedException($request);
    }

    public function generate($name, array $params = []): string
    {
        // Фильруем пустые значения на всякий случай
        $args = array_filter($params);
        foreach ($this->routes->getRoutes() as $route) {
            if ($name !== $route->name) {
                continue;
            }
            $url = preg_replace_callback('~\{([^\}]+)\}~', function ($matches) use (&$args) {
                $arg = $matches[0];
                if (array_key_exists($arg, $args) == false) {
                    throw new \InvalidArgumentException("Missing parameter \"{$arg}\"");
                }
                return $args[$arg];
            }, $route->pattern);
            if ($url !== null) {
                return $url;
            }
        }
        throw new RouteNotFoundException($name, $params);
    }
}
