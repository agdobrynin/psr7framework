<?php
namespace Framework\Http\Middleware;

use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Router;
use Psr\Http\Message\ServerRequestInterface;

class RouteMiddleware
{
    private $_router;
    private $_resolver;

    /**
     * Middleware with router
     *
     * @param Router             $router 
     * @param MiddlewareResolver $resolver 
     */
    public function __construct(Router $router, MiddlewareResolver $resolver)
    {
        $this->_router = $router;
        $this->_resolver = $resolver;
    }
    /**
     * Undocumented function
     *
     * @param ServerRequestInterface $request 
     * @param callable               $next 
     * 
     * @return mixed 
     */
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        try {
            $res = $this->_router->match($request);
            foreach ($res->getAttributes() as $attr => $val) {
                $request = $request->withAttribute($attr, $val);
            }
            $middleware = $this->_resolver->resolve($res->getHandler());
            return $middleware($request, $next);
        } catch (RequestNotMatchedException $e) {
            return $next($request);
        }
    }
}
