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
        return $this->next($request, $default);
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

    /**
     * Undocumented function
     *
     * @param ServerRequestInterface $request
     *
     * @return void
     */
    private function next(ServerRequestInterface $request, callable $default): ResponseInterface
    {
        if ($this->_queue->isEmpty()) {
            return $default($request);
        }

        $curent = $this->_queue->dequeue();

        return $curent($request, function (ServerRequestInterface $request) use ($default) {
            return $this->next($request, $default);
        });
    }
}
