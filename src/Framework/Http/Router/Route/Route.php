<?php
namespace Framework\Http\Router\Route;

use Psr\Http\Message\ServerRequestInterface;
use Framework\Http\Router\Result;

/**
 * Undocumented interface
 * 
 * @category Route_Interface
 * @package  Route
 * @author   Name <email@email.com>
 * @license  MIT 
 * @link     http://url.com
 */
interface Route
{
    /**
     * Undocumented function
     *
     * @param ServerRequestInterface $request 
     * 
     * @return Result|null
     */
    public function match(ServerRequestInterface $request): ?Result;

    /**
     * Undocumented function
     *
     * @param mixed $name 
     * @param array $params 
     * 
     * @return string|null
     */
    public function generate($name, array $params = []): ?string;
}
