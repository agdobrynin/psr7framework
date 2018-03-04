<?php

namespace Framework\Http\Router;

use Aura\Router\Exception\RouteNotFound;
use Aura\Router\RouterContainer;
use Framework\Http\Router\Exception\RouteNotFoundException;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Undocumented class
 * 
 * @category Aura_Adapter_Router
 * @package  Router
 * @author   Name <email@email.com>
 * @license  MIT 
 * @link     http://url.com
 */

class AuraRouterAdapter implements Router
{
    /**
     * Undocumented variable
     *
     * @var Aura\Router\RouterContainer
     */
    private $_aura;

    /**
     * Undocumented function
     *
     * @param RouterContainer $aura 
     */
    public function __construct(RouterContainer $aura)
    {
        $this->_aura = $aura;
    }

    /**
     * Undocumented function
     *
     * @param ServerRequestInterface $request 
     *
     * @return Result
     */
    public function match(ServerRequestInterface $request): Result
    {
        $matcher = $this->_aura->getMatcher();
        if ($route = $matcher->match($request)) {
            return new Result($route->name, $route->handler, $route->attributes);
        }

        throw new RequestNotMatchedException($request);
    }

    /**
     * Undocumented function
     *
     * @param string $name 
     * @param array  $params 
     *
     * @return string
     */
    public function generate($name, array $params = [])
    {
        $generator = $this->_aura->getGenerator();
        try {
            return new $generator->generate($name, $params);
        } catch (RouteNotFound $e) {
            throw new RouteNotFoundException($name, $params, $e);
        }
    }
}
