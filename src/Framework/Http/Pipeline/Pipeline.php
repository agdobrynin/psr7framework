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
     * @param callable               $default 
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, callable $default): ResponseInterface
    {
        $deligate = new Next(clone $this->_queue, $default);
        return $deligate($request);
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
