<?php
namespace Framework\Http\Pipeline;

use Psr\Http\Message\ServerRequestInterface;

class MiddlewareResolver
{
    /**
     * Undocumented function
     *
     * @param mixed $handler
     *
     * @return callable
     */
    public function resolve($handler): callable
    {
        if (\is_array($handler)) {
            return $this->_cretaePipe($handler);
        }

        if (\is_string($handler)) {
            return function (ServerRequestInterface $request, callable $next) use ($handler) {
                $object = new $handler();
                return $object($request, $next);
            };
        }

        return $handler;
    }

    /**
     * Undocumented function
     *
     * @param array $handlers
     *
     * @return Pipeline
     */
    private function _cretaePipe(array $handlers): Pipeline
    {
        $pipe = new Pipeline();
        foreach ($handlers as $handler) {
            $pipe->pipe($this->resolve($handler));
        }
        return $pipe;
    }
}
