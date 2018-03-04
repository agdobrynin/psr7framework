<?php
namespace Framework\Http\Router;

use Psr\Http\Message\ServerRequestInterface;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Exception\RouteNotFoundException;

/**
 * Undocumented interface
 * 
 * @category Router_Interface
 * @package  Router
 * @author   Name <email@email.com>
 * @license  MIT 
 * @link     http://url.com
 */
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
