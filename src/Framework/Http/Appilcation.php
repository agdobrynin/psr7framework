<?php
namespace Framework\Http;

use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Pipeline\Pipeline;
use Psr\Http\Message\ServerRequestInterface;

class Appilcation extends Pipeline
{
    /**
     * Резоллвер для миддлвар
     *
     * @var Framework\Http\Pipeline\MiddlewareResolver
     */
    private $_resovler;

    /**
     * Действие если нет разрешенных действий (мидлвар)
     *
     * @var callable
     */
    private $_default;

    /**
     * Undocumented function
     *
     * @param MiddlewareResolver $resolver  
     * @param callable           $default  
     */
    public function __construct(MiddlewareResolver $resolver, callable $default)
    {
        parent::__construct();
        $this->_resovler = $resolver;
        $this->_default = $default;
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

    /**
     * Зупск экземпляра приложения
     *
     * @param ServerRequestInterface $request 
     * 
     * @return mixed
     */
    public function run(ServerRequestInterface $request)
    {
        return $this($request, $this->_default);
    }
}
