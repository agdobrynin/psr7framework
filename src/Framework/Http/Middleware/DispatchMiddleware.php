<?php
namespace Framework\Http\Middleware;

use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\Result;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class DispatchMiddleware
{
    private $_resolver;

    /**
     * Undocumented function
     *
     * @param MiddlewareResolver $resolver 
     */
    public function __construct(MiddlewareResolver $resolver)
    {
        $this->_resolver = $resolver;
    }

    /**
     * Undocumented function
     *
     * @param ServerRequestInterface $request 
     * @param callable               $next 
     * 
     * @return void
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $result = $request->getAttribute(Result::class);
        if (!$result) {
            return $next($request);
        }
        $middleware = $this->_resolver->resolve($result->getHandler());
        return $middleware($request, $response, $next);
    }
}
