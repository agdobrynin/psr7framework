<?php
namespace App\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface;



class ProfilerMiddleware
{
    /**
     * Undocumented function
     *
     * @param ServerRequestInterface $request 
     * @param callable               $next 
     * 
     * @return 
     */
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $start = \microtime(true);

        $response = $next($request);

        $stop = \microtime(true);

        return $response->withHeader('X-Profiler-Time', round($stop - $start, 4));
    }
}