<?php
namespace Framework\Http;

use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Pipeline\Pipeline;

class Appilcation extends Pipeline
{
    private $_resovler;

    /**
     * Undocumented function
     *
     * @param MiddlewareResolver $resolver 
     */
    public function __construct(MiddlewareResolver $resolver)
    {
        parent::__construct();
        $this->_resovler = $resolver;
    }

    /**
     * Undocumented function
     *
     * @param mixed $middleware 
     * 
     * @return void
     */
    public function pipe($middleware): void
    {
        parent::pipe($this->_resovler->resolve($middleware));
    }
}
