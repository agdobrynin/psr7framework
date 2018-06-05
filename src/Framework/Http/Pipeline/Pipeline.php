<?php
namespace Framework\Http\Pipeline;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Pipeline
{
    /**
     * Queue of middleware
     *
     * @var \SplQueue
     */
    private $_queue;

    public function __construct()
    {
        $this->_queue = new \SplQueue();
    }

    /**
     * Undocumented function
     *
     * @param ServerRequestInterface $request 
     * @param callable               $next 
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
    {
        $deligate = new Next(clone $this->_queue, $next);
        return $deligate($request, $response);
    }

    /**
     * Undocumented function
     *
     * @param callable $middleware 
     *
     * @return void
     */
    public function pipe(callable $middleware): void
    {
        $this->_queue->enqueue($middleware);
    }

}
