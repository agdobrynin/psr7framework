<?php
namespace Framework\Http\Router;

use Framework\Http\Router\Result;
use Psr\Http\Message\ServerRequestInterface;

class Route
{
    public $name;
    public $pattern;
    public $handler;
    public $tokens;
    public $methods;

    public function __construct($name, $pattern, $handler, array $methods, array $tokens = [])
    {
        $this->name = $name;
        $this->pattern = $pattern;
        $this->handler = $handler;
        $this->tokens = $tokens;
        $this->methods = $methods;
    }

    public function match(ServerRequestInterface $request): ?Result
    {
        if ($this->methods && in_array($request->getMethod(), $this->methods, true) == false) {
            return null;
        }

        $pattern = preg_replace_callback('~\{([^s\}]+)\}~', function ($matches) {
            $arg = $matches[1];
            $repl = $this->tokens[$arg] ?? '[^}]+';
            return '(?P<'.$arg.'>'.$repl.')';
        }, $this->pattern);

        if (preg_match('~^'.$pattern.'$~i', $request->getUri()->getPath(), $matches)) {
            return new Result(
                $this->name,
                $this->handler,
                array_filter($matches, '\is_string', ARRAY_FILTER_USE_KEY)
            );
        }

        return null;
    }

    public function generate($name, array $params = []): ?string
    {
        $args = array_filter($params);

        if ($name !== $this->name) {
            return null;
        }

        $url = preg_replace_callback('~\{([^\}]+)\}~', function ($matches) use (&$args) {
            $arg = $matches[0];
            if (array_key_exists($arg, $args) == false) {
                throw new \InvalidArgumentException("Missing parameter \"{$arg}\"");
            }
            return $args[$arg];
        }, $this->pattern);

        return $url;
    }
}
