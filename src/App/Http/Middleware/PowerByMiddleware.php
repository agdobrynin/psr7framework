<?php
namespace App\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;

class PowerByMiddleware
{
    /**
     * Undocumented function
     *
     * @param ServerRequestInterface $request 
     * 
     * @return Zend\Diactoros\Response\HtmlResponse
     */
    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        /** @var Psr\Http\Message\ResponseInterface */
        $response = $next($request);
        return $response->withHeader('X-Engine', 'Simple PSR-7 php framework');
    }
}