<?php
namespace Framework\Http\Middleware;

use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Result;
use Framework\Http\Router\Router;
use Psr\Http\Message\ServerRequestInterface;

class RouteMiddleware
{
    private $_router;

    /**
     * Middleware with router
     *
     * @param Router $router 
     */
    public function __construct(Router $router)
    {
        $this->_router = $router;
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
            return $next($request->withAttribute(Result::class, $res));
        } catch (RequestNotMatchedException $e) {
            return $next($request);
        }
    }
}
