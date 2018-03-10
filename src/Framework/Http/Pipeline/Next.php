<?php
namespace Framework\Http\Pipeline;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Next
{
    private $_default;

    private $_queue;

    /**
     * Undocumented function
     *
     * @param \SplQueue $queue 
     * @param callable  $default 
     */
    public function __construct(\SplQueue $queue, callable $default)
    {
        $this->_queue = $queue;
        $this->_default = $default;
    }

    /**
     * Undocumented function
     *
     * @param \SplQueue              $queue 
     * @param ServerRequestInterface $request 
     *
     * @return Psr\Http\Message\ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->_queue->isEmpty()) {
            return ($this->_default)($request);
        }

        $curent = $this->_queue->dequeue();

        return $curent($request, function (ServerRequestInterface $request) {
            return $this($request);
        });
    }
}
