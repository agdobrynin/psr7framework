<?php
namespace Framework\Http\Router;

use Psr\Http\Message\ServerRequestInterface;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Exception\RouteNotFoundException;

interface Router
{
    /**
     * Сравнение и поиск марштура
     *
     * @param ServerRequestInterface $request 
     * 
     * @throws RequestNotMatchedException
     * 
     * @return Result
     */
    public function match(ServerRequestInterface $request): Result;

    /**
     * Генерация маршрута (url-а)
     *
     * @param string $name 
     * @param array  $params 
     * 
     * @throws RouteNotFoundException
     * 
     * @return string
     */
    public function generate($name, array $params = []);
}
